<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ContactForm extends Block
{
	/**
	 * The block name.
	 *
	 * @var string
	 */
	public $name = 'Contact Form';

	/**
	 * The block slug.
	 *
	 * @var string
	 */
	public $slug = 'fr-page-builder-module-contact-form';

	/**
	 * The block description.
	 *
	 * @var string
	 */
	public $description = 'Contact form block.';

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
	public $icon = [
		'foreground' => '#FF4E00',
		'src' => 'feedback',
	];

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
		return [
			'image' => $this->preview && !get_field('image') ? $this->example['image'] : get_field('image'),
			'heading_content' => get_field('heading_content') ? trim(get_field('heading_content')) : '',
			'contact_form' => get_field('contact_form') ? do_shortcode('[contact-form-7 id="' . get_field('contact_form') . '"]') : false
		];
	}

	public $example = [
		'attributes' => [
			'preview_image' => 'ContactForm.png'
		],
	];

	/**
	 * The block field group.
	 *
	 * @return array
	 */
	public function fields()
	{
		$fields = new FieldsBuilder('contact_form');

		$fields
			->addImage('image')
			->addWysiwyg('heading_content')
			->addPostObject('contact_form', [
				'label' => 'Select Form',
				'return_format' => 'id',
				'post_type' => [
					'wpcf7_contact_form'
				],
				'required' => 1,
				'multiple' => 0
			]);

		return $fields->build();
	}
}
