<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class RelatedContentCardGrid extends Block
{
	/**
	 * The block name.
	 *
	 * @var string
	 */
	public $name = 'Related Content Card Grid';

	/**
	 * The block slug.
	 *
	 * @var string
	 */
	public $slug = 'fr-page-builder-module-related-content-card-grid';

	/**
	 * The block description.
	 *
	 * @var string
	 */
	public $description = 'A Related Content Card Grid block.';

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
	public $icon = ' fricon fricon--related-content-card-grid';

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
		$postsPerPage = get_field('posts_per_page') ?: 8;
		$postType = 'post';
		$getProgram = get_field('after-school-program');
		switch(get_field('post_type')){
			 case 'after-school-program': 
				$getProgram = get_field('after-school-program') ? get_field('after-school-program') : [];
				break;
			case 'camp': 
				$getProgram = get_field('camp') ? get_field('camp') : [];
				break;
			case 'childhood-education': 
				$getProgram = get_field('childhood-education') ? get_field('childhood-education') : [];
				break;
		}
		$result =  array_merge([
			'heading_content' => get_field('heading_content') ? trim(get_field('heading_content')) : '',
			'loadMoreText' => get_field('load_more_button_label'),
			'filterId' => uniqid('card-grid-filter_'),
			'frontendFilters' => $this->getFrontendFilters($postType),
			'postsPerPage' => $postsPerPage,
			'blockData' => [
				'block_name' => 'manual_card_grid',
				'source' => 'filters',
				'posts_per_page' => $postsPerPage,
				'post_type' => ['post'],
				'post_program' => get_field('post_type'),
				'posts' => [],
				'taxonomies' => [],
				'programs' => $getProgram
			]
		]);

		return $result;
	}

	public $example = [
		'attributes' => [
			'preview_image' => 'RelatedContentCardGrid.png'
		],
	];

	/**
	 * The block field group.
	 *
	 * @return array
	 */
	public function fields()
	{
		$relatedContentCardGrid = new FieldsBuilder('related_content_card_grid');

		$relatedContentCardGrid
			->addWysiwyg('heading_content')
			->addRadio('post_type', [
				'choices' => [
					'after-school-program' => 'After School Program',
					'camp' => 'Camp',
					'childhood-education' => 'Early Childhood Education',
				],
				'required' => 1,
				'layout' => 'horizontal',
				'wrapper' => [
					'width' => 100
				]
			])
			->addNumber('posts_per_page', [
				'label' => 'Cards Per Page',
				'min' => 2,
				'default_value' => 2,
				'wrapper' => [
					'width' => 50
				]
			])
			->addText('load_more_button_label', [
				'label' => '\'View More\' Button Label',
				'default_value' => 'View More',
				'wrapper' => [
					'width' => 50
				]
			])			
			->addPostObject('after-school-program', [
				'label' => 'Selected Programs',
				'return_format' => 'id',
				'post_type' => [
					'after-school-program'
				],
				'required' => 0,
				'multiple' => 1
			])
			->conditional('post_type', '==', 'after-school-program')
			->addPostObject('camp', [
				'label' => 'Selected Camps',
				'return_format' => 'id',
				'post_type' => [
					'camp'
				],
				'required' => 0,
				'multiple' => 1
			])
			->conditional('post_type', '==', 'camp')
			->addPostObject('childhood-education', [
				'label' => 'Selected Programs',
				'return_format' => 'id',
				'post_type' => [
					'childhood-education'
				],
				'required' => 0,
				'multiple' => 1
			])
			->conditional('post_type', '==', 'childhood-education');
			

		return $relatedContentCardGrid->build();
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function exampleData()
	{
		$result = [
			'posts' => [
				view('components.card', [
					'post_type' => 'after-school-program',
					'card_data' => [
						'title' => 'Strategy 1 Name Lorem Ipsum Dolor ',
						'post_type' => 'post',
						'permalink' => '',
						'featured_image' => [
							'url' => ''
						],
						'excerpt' => 'Strategy 1 Name Lorem Ipsum Dolor ',
					]
				])->render()
			],
			'hasMore' => true,
			'ajax_config' => '',
			'source' => 'posts',
			'load_more_text' => 'View More'
		];

		return $result;
	}

	public function getFrontendFilters($postType)
	{

		return array_unique(array_filter([
			in_array($postType, ['post']) ? 'program' : null
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
