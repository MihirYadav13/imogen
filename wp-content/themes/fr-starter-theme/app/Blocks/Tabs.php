<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Tabs extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Tabs';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Tabs block.';

	/**
	 * The block slug.
	 *
	 * @var string
	 */
	public $slug = 'fr-page-builder-module-tabs';

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
    public $icon = 'editor-ul fricon';

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
                'item_label' => 'Item 1',
                'item_id' => 'item-1'
            ],
            [
                'item_label' => 'Item 2',
                'item_id' => 'item-2'
            ],
            [
                'item_label' => 'Item 3',
                'item_id' => 'item-3'
            ]
        ]
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
        $tabs = new FieldsBuilder('tabbed_content');

        $tabs
            ->addRadio('mode', [
                'label' => 'Use Module As:',
                'instructions' => 'Select \'Tabs\' (default) to switch between Tab Panels using the Tab Panels module and assigning the same \'Item ID\' value to each Tab Panel inside the Tab Panels module. Select \'Anchors\' to scroll to the position of any block/section on the page that matches the \'Item ID\' with the ID of said block/section.',
                'layout' => 'horizontal',
                'wpml_cf_preferences' => 0,
                'choices' => [
                    'tabs' => 'Tabs',
                    'anchors' => 'Anchors'
                ],
                'default_value' => 'tabs'
            ])
            ->addTrueFalse('sticky_on_scroll', [
                'label' => 'Make tabs sticky on scroll down?'
            ])
            ->addRepeater('tabbed_content_items', [
                'label' => 'Tabs',
                'layout' => 'block'
            ])
                ->addText('item_label', [
                    'wrapper' => [
                        'width' => 60
                    ]
                ])
                ->addText('item_id', [
                    'required' => 1,
                    'wrapper' => [
                        'width' => 40
                    ]
                ])
            ->endRepeater();

        return $tabs->build();
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function items()
    {
        $result = [];

        $result['items'] = [];
        $result['mode'] = get_field('mode');
        $result['sticky_on_scroll'] = get_field('sticky_on_scroll');
        
        if(get_field('tabbed_content_items')){
            $result['items'] = get_field('tabbed_content_items');
        }else{
            if($this->preview){
                $result['items'] = $this->example['items'];
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
