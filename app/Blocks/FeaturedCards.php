<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class FeaturedCards extends Block

{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Featured Cards';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple featured cards block.';

    /**
     * The block slug.
     *
     * @var string
     */
    public $slug = 'fr-page-builder-module-featured-cards';

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
    public $icon = ' fricon fricon--fr-manual-card-grid';

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
        'heading_content' => '',
        'items' => [
            [

                'title' => 'Text Block Title',
                'featured_image' => [
                    'url' => 'https://picsum.photos/seed/picsum/1024/463',
                    'alt' => 'Placeholder image'
                ],
                'cta_link' => [
                    'title' => 'Learn More',
                    'url' => '/'
                ],
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
            [
                'title' => 'Text Block Title',
                'featured_image' => [
                    'url' => 'https://picsum.photos/seed/picsum/1024/463',
                    'alt' => 'Placeholder image'
                ],
                'cta_link' => [
                    'title' => 'Learn More',
                    'url' => '/'
                ],
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ]
        ],
        'attributes' => [
            'preview_image' => 'ManualCardGrid.png',
            'block_icon' => 'manualCardGrid.png'
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
            'items' => ($this->preview && empty(get_field('items')) ? $this->example['items'] : get_field('items')),
            'heading_content' => ($this->preview && empty(get_field('heading_content')) ? $this->example['heading_content'] : trim(get_field('heading_content'))),
        ];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        $featuredCards = new FieldsBuilder('featuredCards');
        $featuredCards
            ->addWysiwyg('heading_content')
            ->addRepeater('items', [
                'layout' => 'block',
                'button_label' => 'Add featured Cards',
                'max' => 8,
            ])
            ->addText('title', [
                'required' => 1,
                'wrapper' => [
                    'width' => 33
                ]
            ])
            ->addImage('featured_image', [
                'required' => 1,
                'wrapper' => [
                    'width' => 33
                ]
            ])
            ->addLink('cta_link', [
                'required' => 1,
                'wrapper' => [
                    'width' => 33
                ]
            ])
            ->addTextarea('description', [
                'required' => 1,
                'maxlength' => 1000,
                'rows' => 3,
                'new_line' => 'br'
            ])

            ->endRepeater();
        return $featuredCards->build();
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
