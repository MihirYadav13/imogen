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
		$postsPerPage = get_field('posts_per_page')?:3;
		$filterConfiguration = get_field('filters_configuration');

		$result =  array_merge([
			'loadMoreText' => get_field('load_more_button_label'),
			'filterId' => uniqid('card-grid-filter_'),
			'frontendFilters' => $this->getFrontendFilters($filterConfiguration),
			'postsPerPage' => $postsPerPage,
			'blockData' => [
				'block_name' => 'card_grid',
				'source' => 'from_filters',
				'posts_per_page' => $postsPerPage,
				'filters_configuration' => $filterConfiguration
			]
		]);

		return $result;
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
			->addRadio('post_type', [
				'choices' => [
					'after-school-program' => 'After School Program',
					'camp' => 'Camp',
					'student-success' => 'Student Success',
					'childhood-education' => 'Childhood Education',
					'team-member' => 'Team Member'
				],
				'required' => 1,
				'layout' => 'horizontal',
				'wrapper' => [
					'width' => 100
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
			->addPostObject('posts', [
				'label' => 'Selected Posts',
				'return_format' => 'id',
				'post_type' => [
					'after-school-program',
					'camp',
					'student-success',
					'childhood-education',
					'team-member'
				],
				'required' => 1,
				'multiple' => 1
			])
				->conditional('source', '==', 'posts')
			->addGroup('taxonomies', [
				'layout' => 'block'
			])
				->conditional('source', '==', 'from_filters')
				->addTaxonomy('age', [
					'label' => 'Age',
					'taxonomy' => 'age',
					'field_type' => 'checkbox',
					'return_format' => 'object',
					'multiple' => 1,
					'add_term' => 0,
					'wrapper' => [
						'width' => 50
					]
				])
					->conditional('post_type', '==', 'after-school-program')
					->or('post_type', '==', 'student-success')
				->addTaxonomy('program', [
					'label' => 'Programs',
					'taxonomy' => 'program',
					'field_type' => 'checkbox',
					'return_format' => 'object',
					'multiple' => 1,
					'add_term' => 0,
					'wrapper' => [
						'width' => 50
					]
				])
					->conditional('post_type', '==', 'after-school-program')
					->or('post_type', '==', 'student-success')
			->endGroup();

		return $cardGrid->build();
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

	public function getFrontendFilters($filterConfiguration){
		$postType = $filterConfiguration['post_type'];

		return array_unique(array_filter([
			in_array($postType, ['after-school-program']) ? 'age' : null,
			in_array($postType, ['camp']) ? 'program' : null,
			in_array($postType, ['student-success']) ? 'activity' : null
		]));
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
