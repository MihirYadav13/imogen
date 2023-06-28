<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PostSearchProvider extends ServiceProvider
{

	const POST_TYPE = 'post';
	const GENERAL_SEARCH_ACTION = 'get_general_search';
	const POSTS_PER_PAGE = 9;

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
		add_action('wp_ajax_' . self::GetAjaxAction('project'), function(){
			return self::GetPostsAjax('project');
		});

		add_action('wp_ajax_nopriv_' . self::GetAjaxAction('project'), function(){
			return self::GetPostsAjax('project');
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
			wp_send_json_success(self::ConvertDataToHtmlArray($result));
		}
	}

	public static function GetPosts($args = []){
		$result = [];

		//default values
		$posts_per_page = isset($args['posts_per_page']) && $args['posts_per_page'] ? intval($args['posts_per_page']) : self::POSTS_PER_PAGE;
		$page = isset($args['page_number']) ? intval($args['page_number']) : 0;
		$post_type = isset($args['post_type']) ? $args['post_type'] : self::POST_TYPE;

		$query_args = [
			'post_type' => $post_type,
			'posts_per_page' => $posts_per_page,
			'offset' => $posts_per_page * $page,
			'post_status' => ['publish'],
			'tax_query' => [],
			'meta_query' => []
		];

		$taxonomies = array_filter([
			$post_type == 'project' ? 'region' : null,
			$post_type == 'project' ? 'service' : null,
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

		$properties = array_filter([
			$post_type == 'project' ? 'year' : null,
			$post_type == 'project' ? 'status' : null
		]);

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
		}

		error_log('$query_args');
		error_log(wp_json_encode($query_args));

		$query = new \WP_Query($query_args);
		wp_reset_postdata();

		return $query->posts ?: $result;
	}

	public static function ConvertDataToHtmlArray($data_arr){
		$result = [];

		foreach ($data_arr?: [] as $i) {
			$card_data = \App\Providers\CardsDataProvider::get($i);
			$result[] = view('components.project-card', [
				'preview' => false,
				'title' => $card_data['title'], 
				'description' => $card_data['excerpt'],
				'image_url' => $card_data['image'] ? $card_data['image']['url'] : false,
				'image_alt' => $card_data['image'] ? $card_data['image']['alt'] : false,
				'url' => $card_data['permalink'] && is_array($card_data['permalink']) ? $card_data['permalink']['url'] : false,
				'url_target' => $card_data['permalink'] && is_array($card_data['permalink']) ? $card_data['permalink']['target'] : false,
				'tag' => $card_data['tag'] ?: []
			])->render();
		}

		return $result;
	}
}
