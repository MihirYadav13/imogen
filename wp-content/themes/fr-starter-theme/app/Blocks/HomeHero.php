<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\CtaButtonFields;

class HomeHero extends Block
{
	/**
	 * The block name.
	 *
	 * @var string
	 */
	public $name = 'Home Hero';

	/**
	 * The block description.
	 *
	 * @var string
	 */
	public $description = 'A simple Home Hero block.';

	/**
	 * The block category.
	 *
	 * @var string
	 */
	public $category = 'fr-page-builder-blocks';

	/**
	 * The block icon.
	 *
	 * @var string|array
	 */
	public $icon = ' fricon fricon--hero';

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
	public $parent = ['acf/fr-page-builder'];

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
		'background_image' => [
			'url' => 'https://picsum.photos/seed/picsum/1280/720',
			'alt' => 'Example Image'
		],
		'background_image_mobile' => [
			'url' => 'https://picsum.photos/seed/picsum/1280/720',
			'alt' => 'Example Image'
		],
		'hero_text' => [
			'title_line_1' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
		],
		'text_box_content' => '<h3>Lorem ipsum dolor sit amet!</h3><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium.</p>',
		'longest_hero_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
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

	/**
	 * The block field group.
	 *
	 * @return array
	 */
	public function fields()
	{
		$hero = new FieldsBuilder('home_hero');

		$hero
			->addImage('background_image', [
				'wrapper' => [
					'width' => 20
				]
			])
			->addImage('background_image_mobile', [
				'wrapper' => [
					'width' => 20
				]
			])
			->addGroup('hero_text')
				->addText('title_line_1', [
					'wrapper' => [
						'width' => 75
					]
				])
				->addTrueFalse('enable_typewritter_effect', [
					'label' => 'Enable Typewriter Effect?',
					'ui' => 1,
					'wrapper' => [
						'width' => 25
					]
				])
				->addRepeater('typewriter_phrases')
					->conditional('enable_typewritter_effect', '==', 1)
					->addText('phrase')
				->endRepeater()
				->addTrueFalse('add_cta_button', [
					'label' => 'Add CTA Button?'
				])
				->addGroup('cta_button')
					->conditional('add_cta_button', '==', '1')
					->addFields($this->get(CtaButtonFields::class))
				->endGroup()
			->endGroup()
			->addTrueFalse('enable_text_box', [
				'ui' => 1,
				'default_value' => 1
			])
			->addWysiwyg('text_box_content')
				->conditional('enable_text_box', '==', 1);

		return $hero->build();
	}

	/**
	 * Return the items field.
	 *
	 * @return array
	 */
	public function items()
	{
		$data = [
			'background_image' => get_field('background_image'),
			'background_image_mobile' => get_field('background_image_mobile')?: get_field('background_image'),
			'hero_text' => get_field('hero_text')['title_line_1'],
			'hero_text_cta' => get_field('hero_text')['add_cta_button'] ? $this->generateCtaButton(get_field('hero_text')['cta_button']) : false,
			'enable_text_box' => get_field('enable_text_box'),
			'text_box_content' => get_field('text_box_content'),
			'enable_typewritter_effect' => get_field('hero_text')['enable_typewritter_effect'],
			'typewriter_phrases' => get_field('hero_text')['typewriter_phrases'] ?: [],
			'longest_hero_text' => $this->getLongestTitle(get_field('hero_text')['title_line_1'], get_field('enable_text_box') ? get_field('hero_text')['typewriter_phrases'] : [])
		];

		if(!$data['background_image'] && !$data['background_image_mobile'] && !$data['hero_text'] && !$data['hero_text_cta'] && !$data['text_box_content'] && !$data['typewriter_phrases'] && $this->preview){
			return $this->example;
		}else{
			return $data;
		}
	}

	public function generateCtaButton($data){
		return view('components.cta-button', [
			'preview' => $this->preview,
			'label' => $data['label'],
			'url' => $data['cta_type'] == 'externa_url' ? $data['externa_url'] : get_permalink($data['post_id']),
			'target' => $data['new_tab'] ? '_blank' : '',
			'style' => $data['style']
		]);
	}

	public function getLongestTitle($title, $phrases){
		$longest = '';

		foreach ($phrases?: [] as $phrase) {
			if(strlen($phrase['phrase']) > strlen($longest)){
				$longest = $phrase['phrase'];
			}
		}

		return $title.$longest;
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
