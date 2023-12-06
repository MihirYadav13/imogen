<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class TestimonialSlider extends Block
{
	/**
	 * The block name.
	 *
	 * @var string
	 */
	public $name = 'Testimonial Slider';

	/**
	 * The block slug.
	 *
	 * @var string
	 */
	public $slug = 'fr-page-builder-module-testimonial-slider';

	/**
	 * The block description.
	 *
	 * @var string
	 */
	public $description = 'A testimonial slider block.';

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
	public $icon = ' fricon fricon--image-carousel';

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
        'image' => [
            [
                'url' => 'https://picsum.photos/seed/picsum/1024/463',
                'alt' => 'Placeholder image'
            ],
        
        ],
        'testimonial_content' => '<p>This is a sample testimonial content.</p>',
        'organization' => 'Sample Organization',
            
        'attributes' => [
            'preview_image' => 'ImageCarousel.png',
            'block_icon' => 'ImageCarousel.png'
        ],
    ];
    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            // 'items' => ($this->preview && empty(get_field('items')) ? $this->example['items'] : get_field('items')),
            'testimonial_content' => get_field('testimonial_content'),
            'title' => get_field('title'),
            'image' => get_field('image'),
            'organization' => get_field('organization'),
        ];
    }
	/**
	 * The block field group.
	 *
	 * @return array
	 */
	public function fields()
	{
		$testimonialSlider = new FieldsBuilder('testimonialSlider');
		$testimonialSlider
        // ->addRepeater('items', [
        //     'layout' => 'block',
        //     'collapsed' => 'title',
        //     'button_label' => 'Add Testimonial Slider Item',
        // ])
		->addWysiwyg('testimonial_content')
        ->addText('title', [
                'required' => 1,
                'wrapper' => [
                    'width' => 33
                ]
                ])


        ->addImage('image', [
                'required' => 1,
                'wrapper' => [
                    'width' => 33
                ]
                ])
        ->addTextarea('organization', [
                'required' => 1,
                'maxlength' => 1000,
                'rows' => 3,
                'new_line' => 'br'
        ]);
          
           
        // ->addText('testimonail_slider_end')
            // ->endRepeater();
        return $testimonialSlider->build();
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
