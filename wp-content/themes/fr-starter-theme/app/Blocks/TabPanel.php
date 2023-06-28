<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class TabPanel extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Tab Panel';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Tab Panel block.';

    /**
     * The block category.
     *
     * @var string
     */
    public $category = 'formatting';

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
    public $parent = [
        'acf/fr-page-builder-module-tab-panels'
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
        'anchor' => false,
        'mode' => false,
        'multiple' => true,
        'jsx' => true,
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
        $tabPanel = new FieldsBuilder('tab_panel');

        $tabPanel
            ->addNumber('index', [
                'wrapper' => [
                    'class' => 'hidden'
                ]
            ])
            ->addText('tab_panel_id', [
                'required' => 1
            ]);

        return $tabPanel->build();
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function items()
    {
        $allowed_blocks = [
            'acf/fr-page-builder-module-wysiwyg',
            'acf/fr-page-builder-module-icons-showcase',
            'acf/fr-page-builder-module-layout',
            'acf/fr-page-builder-module-cta',
            'acf/fr-page-builder-module-card-grid',
            'acf/fr-page-builder-module-tags-tooltips',
        ];
        
        return [
            'allowed_blocks' => json_encode($allowed_blocks),
            'tab_panel_id' => get_field('tab_panel_id')
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
