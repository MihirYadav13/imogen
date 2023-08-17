<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ManualCardGrid extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Manual Card Grid';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple manual card grid.';

	/**
	 * The block slug.
	 *
	 * @var string
	 */
	public $slug = 'fr-page-builder-module-manual-card-grid';

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
        'items' => [
             [
                'title' => 'Text Block Title',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
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
        $manualCard = new FieldsBuilder('manualCardGrid');
        $manualCard
        ->addRepeater('items', [
            'layout' => 'block',
            'button_label' => 'Add Manual Card',
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
            ->addTextarea('description',[ 
                'required' => 1,
                'maxlength' => 1000,
                'rows' => 3,
                'new_line' => 'br'
            ])
                       
        ->endRepeater();
        return $manualCard->build();
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
