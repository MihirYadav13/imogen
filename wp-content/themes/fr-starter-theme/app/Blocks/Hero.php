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
        'defaultData' => [
            'background_image' => [
                'url' => 'https://picsum.photos/seed/picsum/1280/720',
                'alt' => 'Example Image'
            ],
            'background_image_mobile' => [
                'url' => 'https://picsum.photos/seed/picsum/720/480',
                'alt' => 'Example Image'
            ],
            'content' => '<p style="text-align:center;">Add content <b>here</b>.</p>'
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
            'background_image' => get_field('background_image'),
            'background_image_mobile' => get_field('background_image_mobile')?: get_field('background_image'),
            'content' => get_field('content'),
        ];

        if($this->preview){
            if(!get_field('background_image') && !get_field('background_image_mobile') && !get_field('content')){
                $result = $this->example['defaultData'];
            }
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
            ->addWysiwyg('content');

        return $hero->build();
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
