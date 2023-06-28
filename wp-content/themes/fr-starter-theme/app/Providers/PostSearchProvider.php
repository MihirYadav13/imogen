<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PostSearchProvider extends ServiceProvider
{

	const POST_TYPE = 'post';
	const GENERAL_SEARCH_ACTION = 'get_general_search';
	const GENERAL_SEARCH_POST_TYPES = ['post', 'page', 'event', 'resource', 'news', 'people'];
	const POSTS_PER_PAGE = 9;

	//CUSTOM FIELD FOR SORTING ELEMENTS BETWEEN DIFFERENT POST TYPES
	const DATE_SORT_FIELD = 'custom_date_sort';

    /**
     * Register any application services.
     *
     * @return void
     */
	public function register(){

		add_action('init', '\\App\Providers\PostSearchProvider::SetAjaxActions', 20);

		add_action('save_post', function ($post_id, $post){
			if(in_array($post->post_type, ['event', 'news', 'resource', 'page', 'people']) && !wp_is_post_autosave($post) && $post->post_status !== 'auto-draft' && !wp_is_post_revision($post_id)){
				self::SetDateSortField($post_id);
			}
		}, 10, 2);
	}

	public static function GetAjaxAction($post_type = ''){
		$result = 'get_posts';

		switch ($post_type) {
			case 'project':
				$result = 'get_projects';
				break;
			default:
				$result = self::GENERAL_SEARCH_ACTION;
				break;
		}

		return $result;
	}

	public static function SetAjaxActions(){
		//PROJECTS
		//wp_die(var_dump(self::GetAjaxAction('general')));
		add_action('wp_ajax_' . self::GetAjaxAction('general'), function(){
			return self::GetPostsAjax('general');
		});

		add_action('wp_ajax_nopriv_' . self::GetAjaxAction('general'), function(){
			return self::GetPostsAjax('general');
		});
		//THE REST
		//TO DO
	}

	public static function GetPostsAjax($post_type = self::POST_TYPE){
		$args = [
			'post_type' => $post_type,
			'posts_per_page' => filter_input(INPUT_GET, 'posts_per_page')?: false,
			'page_number' => filter_input(INPUT_GET, 'page_number')?: false,
			'search' => filter_input(INPUT_GET, 'search')?: false,
			'region' => filter_input(INPUT_GET, 'region')?: false,
			'service' => filter_input(INPUT_GET, 'service')?: false,
			'year' => filter_input(INPUT_GET, 'year')?: false,
			'status' => filter_input(INPUT_GET, 'status')?: false,
		];

		$result = self::GetPosts($args);

		if(is_wp_error($result)){
			wp_send_json_error($result);
		}else{
			wp_send_json_success(self::ConvertDataToHtmlArray($result, $post_type == 'general' ? 'search-result-card' : $post_type));
		}
	}

	public static function GetPosts($args = []){
		$result = [];

		//default values
		$posts_per_page = isset($args['posts_per_page']) && $args['posts_per_page'] ? intval($args['posts_per_page']) : self::POSTS_PER_PAGE;
		$page = isset($args['page_number']) ? intval($args['page_number']) : 0;
		$post_type = isset($args['post_type']) ? $args['post_type'] : self::POST_TYPE;
		$is_general_search = false; //this flgas makes it so we can search on the terms associated as well, for now it only works on general search

		//FOR GENERAL SEARCH
		if($post_type == 'general'){
			$is_general_search = true;
		}

		$query_args = [
			'post_type' => $post_type == 'general' ? self::GENERAL_SEARCH_POST_TYPES : $post_type,
			'posts_per_page' => $posts_per_page,
			'offset' => $posts_per_page * $page,
			'post_status' => ['publish'],
			'has_password' => false,
			'tax_query' => [],
			'meta_query' => []
		];

		$taxonomies = array_filter([
			$post_type == 'general' ? 'program' : null,
		]);

		foreach($taxonomies as $t){
			$query_args['tax_query'] = isset($args[$t]) && $args[$t] ? array_merge($query_args['tax_query'], [
				[
					'taxonomy' => $t,
					'field' => 'slug',
					'terms' => $args[$t],
					'operator' => 'IN'
				]
			]) : $query_args['tax_query'];
		}

		$properties = array_filter([]);

		foreach ($properties as $p) {
			$query_args['meta_query'] = isset($args[$p]) && $args[$p] ? array_merge($query_args['meta_query'], [
				[
					'key' => $p,
					'value' => $args[$p],
					'compare' => '='
				]
			]) : $query_args['meta_query'];
		}


		if(isset($args['search']) && $args['search']){
			$query_args['s'] = $args['search'];

			if($is_general_search){
				//Reset offset parameters
				$query_args['posts_per_page'] = -1;
				$query_args['offset'] = 0;
				$search_term = $query_args['s'];
	
				//what we do here is use combined queries to do a combined query with [s] parameter AND 
				//a query with taxonomy search LIKE
				$second_query = $query_args;
	
				//remove search term so that the taxonomy query is respected
				$second_query['s'] = false; 
	
				//get the terms that match LIKE search term
				$matched_term_ids = get_terms([
					'taxonomy'   => 'post_tag',
					'name__like' => $args['search'],
					'fields' => 'ids'
				]);
	
				//Build second taxonomy
				$second_query['tax_query'] = array_merge($second_query['tax_query'], [
					[
						'taxonomy' => 'post_tag',
						'field' => 'id',
						'terms' => $matched_term_ids,
						'operator' => 'IN'
					]
				]);
	
				//Build new combined query
				$query_args = [
					'combined_query' => [
						'args' => [ $query_args, $second_query ],
						'union' => 'UNION',
						'posts_per_page' => $posts_per_page,
						'offset' => $posts_per_page * $page,
					]
				];
			}
		}


		add_filter( 'cq_orderby', $callback = function( $orderby ) use ($search_term) {
			return self::RelevanceSearchFilter($search_term) . ', combined.post_date DESC';
		});

		$query = new \WP_Query($query_args);
		wp_reset_postdata();

		remove_filter( 'cq_sub_fields', $callback );

		return $query->posts ?: $result;
	}

	public static function ConvertDataToHtmlArray($data_arr, $template_name = 'search-result-card'){
		$result = [];

		foreach ($data_arr?: [] as $i) {
			$card_data = \App\Providers\CardsDataProvider::get($i);

			$result[] = view('components.' . $template_name, [
				'post_type' => $card_data['post_type'],
				'permalink' => $card_data['permalink'],
				'title' => $card_data['title'],
				'excerpt' => $card_data['excerpt'],
				'program_tags' => $card_data['program_tags'],
				'image' => $card_data['image']
			])->render();
		}

		return $result;
	}

	public static function SetDateSortField($post_id){
		$post_type = get_post_type($post_id);
		$post_creation_date_unix = strtotime(get_the_date('', $post_id));
		$field_value = $post_creation_date_unix;

		switch ($post_type) {
			case 'event':
				$field_value = strtotime(get_field('start_date', $post_id));
				break;
			default:
				break;
		}

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
