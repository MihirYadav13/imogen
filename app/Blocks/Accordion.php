<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Accordion extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Accoradion';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Accordion block.';

    /**
     * The block slug.
     *
     * @var string
     */
    public $slug = 'fr-page-builder-module-accordion';

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
    public $icon = ' fricon fricon--fr-accordion';

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
                'title' => 'Accordion Title',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ]
        ],
        'attributes' => [
            'preview_image' => 'AccordionPreview.png',
            'block_icon' => 'accordion.png'
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
        $accordion = new FieldsBuilder('accordion');
        $accordion
            ->addRepeater('items', [
                'layout' => 'block',
                'collapsed' => 'title',
                'button_label' => 'Add Accordion Item',
            ])
            ->addText('title', [
                'required' => 1,
                'wrapper' => [
                    'width' => 40
                ]
            ])
            ->addWysiwyg('content')
            ->addAccordion('Extra Settings', [
                'wrapper' => [
                    'class' => 'acfhc-accordion'
                ]
            ])
            ->addText('item_id', [
                'label' => 'Item ID',
                'instructions' => 'Add the Accordion Item ID to anchor to opened page with item opened'
            ])
            ->addAccordion('accordion_end')->endpoint()
            ->endRepeater();
        return $accordion->build();
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
