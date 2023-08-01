<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class LogoGrid extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Logo Grid';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Logo Grid block.';

	/**
	 * The block slug.
	 *
	 * @var string
	 */
	public $slug = 'fr-page-builder-module-logo-grid';

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
    public $icon = ' fricon fricon--fr-logo-grid';

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
        'items' => [
            [
                'name' => 'Partner name',
                'logo_image'=> [
                    'url' => 'https://picsum.photos/seed/picsum/500/500',
                    'alt' => 'Placeholder image'
                ],
            ],
            [
                'name' => 'Partner name',
                'logo_image'=> [
                    'url' => 'https://picsum.photos/seed/picsum/500/500',
                    'alt' => 'Placeholder image'
                ],
            ],
            [
                'name' => 'Partner name',
                'logo_image'=> [
                    'url' => 'https://picsum.photos/seed/picsum/500/500',
                    'alt' => 'Placeholder image'
                ],
            ],
            [
                'name' => 'Partner name',
                'logo_image'=> [
                    'url' => 'https://picsum.photos/seed/picsum/500/500 ',
                    'alt' => 'Placeholder image'
                ],
            ]
        ],
        'attributes' => [
            'preview_image' => 'LogoGrid.png',
            'block_icon' => 'LogoGrid.png'
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
            'items' => ($this->preview && empty(get_field('items')) ? $this->example['items'] : get_field('items'))
        ];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        $logoGrid = new FieldsBuilder('logoGrid');
        $logoGrid
        ->addRepeater('items', [
            'layout' => 'block',
            'button_label' => 'Add Logo Grid Item',
            'max' => 15,
        ])
            ->addText('name', [
                'required' => 1,
                'wrapper' => [
                    'width' => 33
                ]
            ])
            ->addImage('logo_image', [
                'required' => 1,
                'wrapper' => [
                    'width' => 33
                ]
            ])
            ->addLink('link', [
                'required' => 0,
                'wrapper' => [
                    'width' => 33
                ]
            ])
        ->endRepeater();
        return $logoGrid->build();
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
