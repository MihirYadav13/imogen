<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class TabPanels extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Tab Panels';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Tab Panels block.';

    /**
	 * The block slug.
	 *
	 * @var string
	 */
	public $slug = 'fr-page-builder-module-tab-panels';


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
        $append_block_name = 'acf/tab-panel';

        $allowed_blocks = [
            $append_block_name
        ];

        return [
            'append_block_name' => $append_block_name,
            'allowed_blocks' => wp_json_encode($allowed_blocks)
        ];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function items()
    {
        return [];
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
