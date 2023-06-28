<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Timeline extends Block
{
	/**
	 * The block name.
	 *
	 * @var string
	 */
	public $name = 'Timeline';

	/**
	 * The block slug.
	 *
	 * @var string
	 */
	public $slug = 'fr-page-builder-module-timeline';

	/**
	 * The block description.
	 *
	 * @var string
	 */
	public $description = 'A simple Timeline block.';

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
	public $icon = 'editor-ul fricon';

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
	 * The block preview example data.
	 *
	 * @var array
	 */
	public $example = [
		'timeline_cards' => [
			[
				'card_image' => [
					'url' => 'https://fakeimg.pl/50x50/?text=Icon',
					'alt' => 'Example Image'
				],
				'card_data' => [
					'date' => 'January 1, 2023',
					'title' => 'Example Card',
					'description' => 'This an preview example, start editing content <b>here</b>',
				],
				'modal_image' => false,
				'modal_content' => ''
			],
			[
				'card_image' => [
					'url' => 'https://fakeimg.pl/50x50/?text=Icon',
					'alt' => 'Example Image'
				],
				'card_data' => [
					'date' => 'January 1, 2023',
					'title' => 'Example Card 2',
					'description' => 'This an preview example, start editing content <b>here</b>',
				],
				'modal_image' => false,
				'modal_content' => ''
			],
			[
				'card_image' => [
					'url' => 'https://fakeimg.pl/50x50/?text=Icon',
					'alt' => 'Example Image'
				],
				'card_data' => [
					'date' => 'January 1, 2023',
					'title' => 'Example Card 3',
					'description' => 'This an preview example, start editing content <b>here</b>',
				],
				'modal_image' => false,
				'modal_content' => ''
			]
		],
	];

	/**
	 * Data to be passed to the block before rendering.
	 *
	 * @return array
	 */
	public function with()
	{
		$result = [
			'timeline_cards' => get_field('timeline_cards')
		];

		if($this->preview && (!$result['timeline_cards'] || count($result['timeline_cards']) == 0)){
			$result = $this->example;
		}

		return $result;
	}

	/**
	 * The block field group.
	 *
	 * @return array
	 */
	public function fields()
	{
		$timeline = new FieldsBuilder('timeline');

		$timeline
			->addRepeater('timeline_cards', [
				'layout' => 'block'
			])
				->addImage('card_image', [
					'wrapper' => [
						'width' => 25
					]
				])
				->addGroup('card_data', [
					'layout' => 'block',
					'wrapper' => [
						'width' => 75
					]
				])
					->addText('date')
					->addText('title')
					->addTextarea('description', [
						'rows' => 3
					])
				->endGroup()
                ->addAccordion('Modal Content', [
                    'wrapper' => [
                        'class' => 'acfhc-accordion'
                    ]
                ])
					->addImage('modal_image', [
						'wrapper' => [
							'width' => 25
						]
					])
					->addWysiwyg('modal_content', [
						'media_upload' => 0,
						'wrapper' => [
							'width' => 75
						]	
					])
                ->addAccordion('accordion_end')->endpoint()
			->endRepeater();

		return $timeline->build();
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
