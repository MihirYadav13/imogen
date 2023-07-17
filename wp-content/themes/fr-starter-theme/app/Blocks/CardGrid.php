<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\CardGridFilters;

class CardGrid extends Block
{
	/**
	 * The block name.
	 *
	 * @var string
	 */
	public $name = 'Card Grid';

	/**
	 * The block slug.
	 *
	 * @var string
	 */
	public $slug = 'fr-page-builder-module-card-grid';

	/**
	 * The block description.
	 *
	 * @var string
	 */
	public $description = 'A Card Grid block.';

	/**
	 * The block category.
	 *
	 * @var string
	 */
	public $category = 'fr-page-builder-content-blocks';

	/**
	 * The block icon.
	 *
	 * @var string|array
	 */
	public $icon = ' fricon fricon--card-grid';

	/**
	 * The block keywords.
	 *
	 * @var array
	 */
	public $keywords = [];

	/**
	 * The block post type allow list.
	 *
	 * @var array
	 */
	public $post_types = [];

	/**
	 * The parent block type allow list.
	 *
	 * @var array
	 */
	public $parent = ['acf/block-container'];


	/**
	 * The default block mode.
	 *
	 * @var string
	 */
	public $mode = 'preview';

	/**
	 * The default block alignment.
	 *
	 * @var string
	 */
	public $align = '';

	/**
	 * The default block text alignment.
	 *
	 * @var string
	 */
	public $align_text = '';

	/**
	 * The default block content alignment.
	 *
	 * @var string
	 */
	public $align_content = '';

	/**
	 * The supported block features.
	 *
	 * @var array
	 */
	public $supports = [
		'align' => false,
		'align_text' => false,
		'align_content' => false,
		'full_height' => false,
		'anchor' => true,
		'mode' => 'edit',
		'multiple' => true,
		'jsx' => true,
	];

	/**
	 * Data to be passed to the block before rendering.
	 *
	 * @return array
	 */
	public function with()
	{
		return $this->items();
	}

	public $example = [
		'attributes' => [
            'preview_image' => 'CardGrid.png'
        ],
	];

	/**
	 * The block field group.
	 *
	 * @return array
	 */
	public function fields()
	{
		$cardGrid = new FieldsBuilder('card_grid');

		$cardGrid
			->addRadio('source', [
				'choices' => [
					'posts' => 'Select from Posts',
					'from_filters' => 'Dynamically Pulled from Filters',
				],
				'layout' => 'horizontal',
				'default_value' => 'posts',
				'wrapper' => [
					'width' => 50
				]
			])
			->addNumber('posts_per_page', [
				'label' => 'Cards Per Page',
				'min' => 3,
				'default_value' => 3,
				'wrapper' => [
					'width' => 50
				]
			])
			->addText('load_more_button_label', [
				'label' => '\'Load More\' Button Label',
				'default_value' => 'Load More',
				'wrapper' => [
					'width' => 50
				]
			])
			->addPostObject('posts', [
				'label' => 'Selected Posts',
				'return_format' => 'id',
				'post_type' => [
					'strategy',
					'case-study',
					'resource'
				],
				'required' => 1,
				'multiple' => 1
			])
				->conditional('source', '==', 'posts')
			->addGroup('filters_configuration')
				->conditional('source', '==', 'from_filters')
				->addFields($this->get(CardGridFilters::class))
			->endGroup();

		return $cardGrid->build();
	}

	/**
	 * Return the items field.
	 *
	 * @return array
	 */
	public function items()
	{

		$cardsResult = [
			'posts' => [],
			'hasMore' => false
		];
		$source = get_field('source');
		$isSlider = get_field('layout')?get_field('layout') === 'slider': false;
		$postsPerPage = $isSlider ? (get_field('card_count') ?: 6) : (get_field('posts_per_page')? : 3);
		$filterConfiguration = get_field('filters_configuration');
		$posts = get_field('posts');
		$blockData = [
			'block_name' => 'card_grid',
			'source' => $source,
			'posts_per_page' => $postsPerPage,
			'posts' => $posts,
            'filters_configuration' => $filterConfiguration
		];

		switch ($source) {
			case 'posts':
				$cardsResult = $this->getCardsFromPosts($posts, $postsPerPage);
				break;
			case 'from_filters':
				$cardsResult = $this->getCardsFromFilters($filterConfiguration, $postsPerPage);
				break;
			default:
				break;
		}

		$result =  array_merge([
			'ajax_config' => \App\Providers\PostSearchProvider::GetAjaxConfig($blockData),
			'is_slider' => $isSlider,
			'source' => $source,
			'load_more_text' => get_field('load_more_button_label')
		], $cardsResult);

		if($this->preview && empty($result['posts'])){
            return $this->exampleData();
        }

		return $result;
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function exampleData() {
		$result = [
			'posts' => [
				view('components.card', [
					'post_type' => 'strategy',
					'card_data' => [
						'title' => 'Strategy 1 Name Lorem Ipsum Dolor ',
						'date' => 'January 1, 2023',
						'is_featured' => false,
						'likes' => 10,
						'topics' => [
							(object)[
								'post_title' => 'Adult Learners'
							]
						],
						'keyword_tags' => [
							(object)[
								'name' => 'Research'
							]
						]
					]
				])->render(),
				view('components.card', [
					'post_type' => 'strategy',
					'card_data' => [
						'title' => 'Strategy 2 Name Lorem Ipsum Dolor ',
						'date' => 'January 1, 2023',
						'is_featured' => false,
						'likes' => 10,
						'topics' => [
							(object)[
								'post_title' => 'Adult Learners'
							]
							],
						'keyword_tags' => [
							(object)[
								'name' => 'Research'
							]
						]
					]
				])->render(),
				view('components.card', [
					'post_type' => 'strategy',
					'card_data' => [
						'title' => 'Strategy 3 Name Lorem Ipsum Dolor ',
						'date' => 'January 1, 2023',
						'is_featured' => false,
						'likes' => 10,
						'topics' => [
							(object)[
								'post_title' => 'Adult Learners'
							]
						],
						'keyword_tags' => [
							(object)[
								'name' => 'Research'
							]
						]
					]
				])->render()
			],
			'hasMore' => true,
			'ajax_config' => '',
			'is_slider' => false,
			'source' => 'posts',
			'load_more_text' => 'Load More'
		];

		return $result;
	}

	public function getCardsFromPosts($posts, $postsPerPage = 3){
		$result = [];

		$args = [
			'post_type' => \App\Providers\PostSearchProvider::GENERAL_SEARCH_POST_TYPES,
			'posts_per_page' => $postsPerPage?: 3,
			'post__in' => $posts,
			'order_by' => 'post__in'
		];

		$result = \App\Providers\PostSearchProvider::GetPosts($args);

		return ['posts' => \App\Providers\PostSearchProvider::ConvertDataToHtmlArray($result['posts']), 'hasMore' => $result['hasMore']];
	}

	public function getCardsFromFilters($filters, $postsPerPage = 3){
		$result = [];

		$args = [
			'post_type' => $filters['post_types'],
			'posts_per_page' => $postsPerPage?: 3,
			'resource-type' => \App\Providers\PostSearchProvider::GetTermsSlugs($filters['taxonomies']['resource-type']),
			'keyword-tag' => \App\Providers\PostSearchProvider::GetTermsSlugs($filters['taxonomies']['keyword-tag']),
			'selected_topics' => $filters['taxonomies']['topic'],
			'related_strategies' => $filters['taxonomies']['strategy'],
		];

		$result = \App\Providers\PostSearchProvider::GetPosts($args);

		return ['posts' => \App\Providers\PostSearchProvider::ConvertDataToHtmlArray($result['posts']), 'hasMore' => $result['hasMore']];
	}


	/**
	 * Assets to be enqueued when rendering the block.
	 *
	 * @return void
	 */
	public function enqueue()
	{
		//
	}
}
