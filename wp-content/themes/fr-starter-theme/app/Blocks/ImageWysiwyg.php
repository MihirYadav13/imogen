<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ImageWysiwyg extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Image Wysiwyg Module';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Image+Wysiwyg Module block.';

    /**
     * The block slug.
     *
     * @var string
     */
    public $slug = 'fr-page-builder-module-image-wysiwyg';

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
        'src' => 'welcome-widgets-menus',
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
    public $parent = [
        'acf/block-container'
    ];

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
            'url' => 'https://picsum.photos/seed/picsum/1024/463',
            'alt' => 'Placeholder image'
        ],
        'content' => '<h5 class="sub"><span class="theme-color">ABOUT OUR PROGRAMS</span></h5>
<h3 class="sub">IF Afterschool programs support the</h3>
<div class="news-paper-column">Our afterschool programs operate every day after school, from the first Monday that schools are in session in September, through the last Friday that schools are open in June. We provide high quality childcare with a diverse menu of enrichment activities.</div>',
        'attributes' => [
            'preview_image' => 'ImgaeWysiwyg.png'
        ],
        'image_size' => '1/3',
        'flip_orientation' => 'false',
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
        $imageWysiwyg = new FieldsBuilder('fr_page_builder_module_image_wysiwyg');

        $imageWysiwyg
            ->addImage('image', [
                'wrapper' => [
                    'width' => '30'
                ]
            ])
            ->addWysiwyg('content', [
                'wrapper' => [
                    'width' => '70'
                ]
            ])
            ->addSelect('image_size', [
                'choices' => ['1/3', '1/2', '2/3'],
                'default_value' => [],
                'ui' => 0,
                'return_format' => 'value',
                'placeholder' => '',
                'wrapper' => [
                    'width' => '50'
                ]
            ])
            ->addTrueFalse('flip_orientation', [
                'label' => 'Flip Orientation',
                'default_value' => 0,
                'ui' => 1,
                'instructions' => 'If you add the image on the Content Right, Please turn on.',
                'wrapper' => [
                    'width' => '50',
                ]
            ]);


        return $imageWysiwyg->build();
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function items()
    {
        return [
            'image' => $this->preview && !get_field('image') ? $this->example['image'] : get_field('image'),
            'content' => $this->preview && !get_field('content') ? $this->example['content'] : get_field('content'),
            'image_size' => $this->preview && !get_field('image_size') ? $this->example['image_size'] : get_field('image_size'),
            'flip_orientation' => get_field('flip_orientation') ?? $this->example['flip_orientation'],
        ];
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
