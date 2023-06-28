<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Hero extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Hero';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'Default Page Hero block.';

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
    public $parent = [];

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
        'anchor' => false,
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
        'items' => [
            ['item' => 'Item one'],
            ['item' => 'Item two'],
            ['item' => 'Item three'],
        ],
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
        $hero = new FieldsBuilder('hero');

        $hero
            ->addImage('background_image', [
                'wrapper' => [
                    'width' => '50'
                ]
            ])
            ->addImage('background_image_mobile', [
                'wrapper' => [
                    'width' => '50'
                ]
            ])
            ->addWysiwyg('content')
            ->addRadio('content_box_position', [
                'choices' => [
                    'center-full-width' => 'Center Full Width',
                    'left' => 'Left',
                    'right' => 'right' 
                ],
                'wpml_cf_preferences' => 0,
                'default_value' => 'center-full-width',
                'layout' => 'horizontal',
                'wrapper' => [
                    'width' => '50'
                ]
            ])
            ->addRadio('content_box_background_color', [
                'label' => 'Content Box: Background Color',
                'choices' => [
                    'dark-blue' => 'Dark Blue',
                    'white' => 'White' 
                ],
                'layout' => 'horizontal',
                'wpml_cf_preferences' => 0,
                'default_value' => 'dark-blue',
                'wrapper' => [
                    'width' => '50'
                ]
            ]);

        return $hero->build();
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function items()
    {

        $result = [
            'background_image' => get_field('background_image'),
            'background_image_mobile' => get_field('background_image_mobile')?: get_field('background_image'),
            'content' => get_field('content'),
            'content_box_position' => get_field('content_box_position'),
            'content_box_background_color' => get_field('content_box_background_color')
        ];

        if($this->preview){
            if(!get_field('background_image') && !get_field('background_image_mobile') && !get_field('content')){
                $result = [
                    'background_image' => [
                        'url' => 'https://picsum.photos/seed/picsum/1280/720',
                        'alt' => 'Example Image'
                    ],
                    'background_image_mobile' => [
                        'url' => 'https://picsum.photos/seed/picsum/720/480',
                        'alt' => 'Example Image'
                    ],
                    'content' => '<p style="text-align:center;">Add content <b>here</b>.</p>',
                    'content_box_position' => 'center-full-width',
                    'content_box_background_color' => 'dark-blue'
                ];
            }
        }

        return $result;
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
