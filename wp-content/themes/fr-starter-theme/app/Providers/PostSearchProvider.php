<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PostSearchProvider extends ServiceProvider
{
	public static $tablePrefix;
	const ACTION = 'get_posts';
	const GENERAL_SEARCH_POST_TYPES = ['after-school-program', 'camp', 'post', 'childhood-education', 'team-member'];
	const POSTS_PER_PAGE = 8;
	const ORDER_BY = ['latest', 'oldest', 'post__in'];

	//CUSTOM FIELD FOR SORTING ELEMENTS BETWEEN DIFFERENT POST TYPES
	const DATE_SORT_FIELD = 'custom_date_sort';

    /**
     * Register any application services.
     *
     * @return void
     */
	public function register(){
		global $wpdb;
		self::$tablePrefix = $wpdb->prefix;

		add_action('init', '\\App\Providers\PostSearchProvider::SetAjaxActions', 20);

		add_action('save_post', function ($post_id, $post){
			if(in_array($post->post_type, array_merge(['page'], self::GENERAL_SEARCH_POST_TYPES)) && !wp_is_post_autosave($post) && $post->post_status !== 'auto-draft' && !wp_is_post_revision($post_id)){
				self::SetDateSortField($post_id);
			}
		}, 10, 2);
	}

	public static function SetAjaxActions(){
		add_action('wp_ajax_' . self::ACTION, function(){
			return self::GetPostsAjax();
		});

		add_action('wp_ajax_nopriv_' . self::ACTION, function(){
			return self::GetPostsAjax();
		});
	}

    public static function getAjaxConfig($blockData = []){
        $ajax_config = [
            'url' => home_url('/', is_ssl() ? 'https' : 'http') . 'wp-admin/admin-ajax.php',
            'action' => self::ACTION,
			'post_type' => self::GENERAL_SEARCH_POST_TYPES,
            'posts_per_page' => self::POSTS_PER_PAGE,
            'page' => 1,
            's' => isset($_GET['s']) && strlen($_GET['s']) > 0 ? $_GET['s'] : 0
        ];

		if(!empty($blockData)){
			$ajax_config = array_merge($ajax_config, [
				'posts_per_page' => $blockData['posts_per_page'] ? :self::POSTS_PER_PAGE
			]);

			switch($blockData['block_name']){
				case 'card_grid':
					if($blockData['source'] === 'from_filters'){
						$filterTaxonomies = $blockData['taxonomies'];
						$ajax_config = array_merge($ajax_config, [
							'post_type' => $blockData['post_type'],
							'age' => \App\Providers\PostSearchProvider::GetTermsSlugs($filterTaxonomies['age']??[]),
							'activity' => \App\Providers\PostSearchProvider::GetTermsSlugs($filterTaxonomies['activity']??[]),
							'programs' => $filterTaxonomies['programs']??[],
						]);
					}
					else {
						$ajax_config = array_merge($ajax_config, [
							'post_type' => $blockData['post_type'],
							'post__in' => $blockData['post__in'],
							'orderby' => self::ORDER_BY[2]
						]);
					}
					break;
				case 'manual_card_grid':
					$ajax_config = array_merge($ajax_config, [
						'post_type' => $blockData['post_type'],
						'programs' => $blockData['programs'],
						'post_program' => $blockData['post_program']
					]);	
					break;
				case 'card_grid_component':					
					$ajax_config = array_merge($ajax_config, [
						'post_type' => $blockData['post_type'],
					]);
					break;
				default:
					break;
			}

		}

		return json_encode($ajax_config, JSON_HEX_APOS);
    }


	public static function GetPostsAjax(){
		$args = [
			'post_type' => filter_input(INPUT_GET, 'post_type', FILTER_DEFAULT , FILTER_REQUIRE_ARRAY)?: [],
			'posts_per_page' => filter_input(INPUT_GET, 'posts_per_page')?: false,
			'page' => filter_input(INPUT_GET, 'page')?: false,
			'order_by' => filter_input(INPUT_GET, 'order_by')?: false,
			's' => filter_input(INPUT_GET, 's')?: false,
			'page_number' => filter_input(INPUT_GET, 'page')?: 1,
			'post__in' => filter_input(INPUT_GET, 'post__in', FILTER_DEFAULT , FILTER_REQUIRE_ARRAY)? : [],
			'age' => filter_input(INPUT_GET, 'age', FILTER_DEFAULT , FILTER_REQUIRE_ARRAY)? : [],
			'programs' => filter_input(INPUT_GET, 'programs', FILTER_DEFAULT , FILTER_REQUIRE_ARRAY)? : [],
			'post_program' => filter_input(INPUT_GET, 'post_program')?: '',
		];

		$result = self::GetPosts($args);

		if(is_wp_error($result['posts'])){
			wp_send_json_error($result['posts']);
		}else{
			wp_send_json_success(array_merge($result, ['posts' => self::ConvertDataToHtmlArray($result['posts'])]));
		}
	}

	public static function GetPosts($args = []){
		//default values
		$posts_per_page = isset($args['posts_per_page']) && $args['posts_per_page'] ? intval($args['posts_per_page']) : self::POSTS_PER_PAGE;
		$page = isset($args['page_number']) ? intval($args['page_number']) : 1;
		$post_type = isset($args['post_type']) ? $args['post_type'] : ['page'];
		$order_by = isset($args['order_by']) && in_array($args['order_by'], self::ORDER_BY) ? $args['order_by'] : self::ORDER_BY[0];
		$search = isset($args['s']) && strlen($args['s']) ? $args['s'] : false;
		$post__in = isset($args['post__in']) && is_array($args['post__in']) && count($args['post__in']) ? $args['post__in'] : [];
		$offset = $posts_per_page * ($page - 1);

		$combined_args = [
			'combined_query' => [
				'args' => [],
				'union' => 'UNION',
				'posts_per_page' => $posts_per_page,
				'offset' => $posts_per_page * ($page - 1),
			]
		];

		foreach ($post_type as $pt) {
			$query_args = [
				'post_type' => $pt,
				'posts_per_page' => -1,
				'post_status' => ['publish'],
				'has_password' => false,
				'tax_query' => [],
				'meta_query' => [],
				'post__in' => isset($post__in) && count($post__in) ? $post__in : false,
				's' => $args['s'] ?? false
			];

			$query_args = array_merge($query_args, self::GenerateTaxAndMetaQueriesArray($args, $pt));

			$combined_args['combined_query']['args'][] = $query_args;
		}

		// Modify sub fields:
		add_filter('cq_sub_fields', $subfields_cb = function( $fields ) use ($order_by){
			if($order_by === 'latest' || $order_by === 'oldest'){
				return $fields . ', (SELECT meta_value from '.self::$tablePrefix.'postmeta WHERE '.self::$tablePrefix.'postmeta.post_id = '.self::$tablePrefix.'posts.ID AND '.self::$tablePrefix.'postmeta.meta_key = \''.self::DATE_SORT_FIELD.'\' LIMIT 1) AS date_sort_field';
			}else{
				return $fields;
			}
		});

		//Modify order by:
		add_filter('cq_orderby', $orderby_cb = function( $orderby ) use ($order_by, $search, $post_type, $post__in) {
			return self::getOrderBySQL($order_by, $search, $post_type, $post__in) ?? $orderby;
		});

		$query = new \WP_Query($combined_args);
		wp_reset_postdata();

		remove_filter('cq_sub_fields', $subfields_cb);
		remove_filter('cq_orderby', $orderby_cb);

		return ['posts' => $query->posts, 'hasMore' => ( $page < ceil($query->found_posts)/$posts_per_page) ];
	}


	public static function GetTermsSlugs($terms){
		if(!isset($terms) || empty($terms)){
			return [];
		}

		return array_reduce($terms,function($result, $term) {
            $result[] = $term->slug;
            return $result;
        }, []);
	}

	public static function GenerateTaxAndMetaQueriesArray($args, $post_type){		
		$result = [
			'tax_query' => [],
			'meta_query' => []
		];
		$taxonomies = array_filter([
			in_array($post_type, ['after-school-program', 'camp']) ? 'age' : null,
			in_array($post_type, ['after-school-program', 'camp']) ? 'activity' : null,
		]);

		$relationships = array_filter([
			in_array($post_type, ['post']) ? 'programs' : null,
		]);

		foreach($taxonomies as $t){
			$result['tax_query'] = isset($args[$t]) && $args[$t] ? array_merge($result['tax_query'], [
				[
					'taxonomy' => $t,
					'field' => 'slug',
					'terms' => $args[$t],
					'operator' => 'IN'
				]
			]) : $result['tax_query'];
		}
		

		//for relationships
		foreach ($relationships as $rel) {
			$relationship_meta = [];
			if(isset($args[$rel]) && $args[$rel]){
				$relationship_meta = [
					'relation' => 'OR',
				];
				if(isset($args['post_program']) && $args['post_program']!= '') {
					$relationship_meta[] = [
						'key' => 'program_type',
						'value' => "'".$args['post_program']."'",
						'compare' => 'LIKE'
					];
					if($args['post_program']=='camp'){
						foreach ($args[$rel] as $relId) {
							$relationship_meta[] = [
								'key' => 'related_camp',
								'value' => '"'.$relId.'"',
								'compare' => 'LIKE'
							];					
						}
					}
					else if($args['post_program']=='after-school-program') {
						foreach ($args[$rel] as $relId) {
							$relationship_meta[] = [
								'key' => 'related_program',
								'value' => '"'.$relId.'"',
								'compare' => 'LIKE'
							];					
						}					
					}
				}				
				else{
					foreach ($args[$rel] as $relId) {
						$relationship_meta[] = [
							'key' => 'related_camp',
							'value' => '"'.$relId.'"',
							'compare' => 'LIKE'
						];
						$relationship_meta[] = [
							'key' => 'related_program',
							'value' => '"'.$relId.'"',
							'compare' => 'LIKE'
						];					
					}
				}
			}
			else{
				if(isset($args['post_program']) && $args['post_program']!= '')
				{	
					$relationship_meta = [
						'relation' => 'OR',
					];
					$relationship_meta[] = [
						'key' => 'program_type',
						'value' =>  $args['post_program'],
						'compare' => 'LIKE'
					];
					
				}			
			}
			$result['meta_query'] = array_merge($result['meta_query'], [
				$relationship_meta
			]);
		}

		return $result;
	}

	public static function getOrderBySQL($order_by, $search, $post_types, $post__in = []){
		$result = null;

		//if post__in then it takes precedence
		if($order_by === self::ORDER_BY[2] && count($post__in)){
			return 'field(combined.ID, '.implode(', ', $post__in).')';
		}

		if($order_by === self::ORDER_BY[0]){
			$result[] = 'combined.date_sort_field DESC';
		}

		if($order_by === self::ORDER_BY[1]){
			$result[] = 'combined.date_sort_field ASC';
		}

		if(isset($search) && $search){
			$result[] = self::RelevanceSearchFilter($search);
		}

		return $result ? implode(', ', $result) : $result;
	}

	public static function ConvertDataToHtmlArray($data_arr){
		$result = [];

		foreach ($data_arr?: [] as $post) {
			$card = new \App\View\Components\Card($post);
			$result[] = view('components.card', $card->data() )->render();
		}

		return $result;
	}


	public static function SetDateSortField($post_id){
		$post_type = get_post_type($post_id);
		$post_creation_date_unix = strtotime(get_the_date('', $post_id));
		$field_value = $post_creation_date_unix;

		update_post_meta($post_id, self::DATE_SORT_FIELD, $field_value);
	}

	public static function RelevanceSearchFilter($term){
		global $wpdb;
		$terms = explode(' ', $term);

		$result = "(CASE WHEN combined.post_title LIKE '%$term%' THEN 1 WHEN combined.post_title LIKE ";

		foreach ($terms as $i => $t) {
			$result.= "'%$t%'";
			if($i === count($terms) - 1){
				$result .= ' THEN 2 ';
			}else{
				$result .= " AND combined.post_title LIKE ";
			}
		}

		$result .= ' WHEN combined.post_title LIKE ';

		foreach ($terms as $i => $t) {
			$result.= "'%$t%'";

			if($i === count($terms) - 1){
				$result .= ' THEN 3 ';
			}else{
				$result .= " OR combined.post_title LIKE ";
			}
		}

		$result .= "WHEN combined.post_excerpt LIKE '$term' THEN 4 ";

		$result .= "WHEN combined.post_content LIKE '$term' THEN 5 ELSE 6 END) ASC";

		return $wpdb->add_placeholder_escape($result);
	}
}
