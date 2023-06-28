<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class WeaveSlider extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Weave Slider';

	/**
	 * The block slug.
	 *
	 * @var string
	 */
	public $slug = 'fr-page-builder-module-weave-slider';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Weave Slider block.';

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
    public $icon = 'editor-ul fricon fricon--weave-slider';

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
        'left_side' => [
            'label' => 'Before',
            'image' => [
                'url' => 'https://fakeimg.pl/1280x720/?text=Left%20Side',
                'alt' => 'Placeholder Image'
            ]
        ],
        'right_side' => [
            'label' => 'After',
            'image' => [
                'url' => 'https://fakeimg.pl/1280x720/?text=Right%20Side',
                'alt' => 'Placeholder Image'
            ]
        ],
        'container_height' => 56
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        $result = [
            'left_side' => get_field('left_side'),
            'right_side' => get_field('right_side'),
            'container_height' => get_field('container_height')
        ];

        if($this->preview && (!$result['left_side']['image'] && !$result['left_side']['label'] && !$result['right_side']['image'] && !$result['left_side']['label'])){
            $result = $this->example;
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
        $weaveSlider = new FieldsBuilder('weave_slider');

        $weaveSlider
            ->addGroup('left_side', [
                'wrapper' => [
                    'width' => '50'
                ]
            ])
                ->addText('label')
                ->addImage('image')
            ->endGroup()
            ->addGroup('right_side', [
                'wrapper' => [
                    'width' => '50'
                ]
            ])
                ->addText('label')
                ->addImage('image')
            ->endGroup()
            ->addRange('container_height', [
                'label' => 'Container\'s Height',
                'min' => 1,
                'max' => 100,
                'append' => '%',
                'default_value' => 56
            ]);

        return $weaveSlider->build();
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function items()
    {
        return get_field('items') ?: $this->example['items'];
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
