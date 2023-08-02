<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\CardGridFilters;

class ImageCarousel extends Block
{
	/**
	 * The block name.
	 *
	 * @var string
	 */
	public $name = 'Image Carousel';

	/**
	 * The block slug.
	 *
	 * @var string
	 */
	public $slug = 'fr-page-builder-module-image-carousel';

	/**
	 * The block description.
	 *
	 * @var string
	 */
	public $description = 'A image carousel block.';

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
        'images' => [
            [
                'carousel_image'=> [
                    'url' => 'https://via.placeholder.com/814x463',
                    'alt' => 'Placeholder image'
                ],
            ],
            [
                
                'carousel_image'=> [
                    'url' => 'https://via.placeholder.com/814x463',
                    'alt' => 'Placeholder image'
                ],
            ],
            [
                
                'carousel_image'=> [
                    'url' => 'https://via.placeholder.com/814x463',
                    'alt' => 'Placeholder image'
                ],
            ],
            [
                
                'carousel_image'=> [
                    'url' => 'https://via.placeholder.com/814x463',
                    'alt' => 'Placeholder image'
                ],
            ]
        ],
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
            'images' => ($this->preview && empty(get_field('images')) ? $this->example['images'] : get_field('images'))
        ];
    }
	/**
	 * The block field group.
	 *
	 * @return array
	 */
	public function fields()
	{
		$imageCarousel = new FieldsBuilder('imageCarousel');
		$imageCarousel
		->addGallery('images', [
			'label' => 'Carousel Image',
			'max' => '15',
			'insert' => 'append',
			'library' => 'all',
			'mime_types' => 'jpg,jpeg,png'
		]);
        return $imageCarousel->build();
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
