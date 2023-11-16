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
    public $description = 'A Featured Cards block.';
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
    public $icon = ' fricon fricon--featured-cards' ;
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
                'image' => [
                    'url' => 'https://picsum.photos/seed/picsum/1024/463',
                    'alt' => 'Placeholder image'
                ],
                'title' => 'Featured Card Title',
                'sub_title' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do.',
            ],
            [
                'image' => [
                    'url' => 'https://picsum.photos/seed/picsum/1024/463',
                    'alt' => 'Placeholder image'
                ],
                'title' => 'Featured Card Title',
                'sub_title' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do.',
            ],
            [
                'image' => [
                    'url' => 'https://picsum.photos/seed/picsum/1024/463',
                    'alt' => 'Placeholder image'
                ],
                'title' => 'Featured Card Title',
                'sub_title' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do.',
            ]
        ],
        'attributes' => [
            'preview_image' => 'FeaturedCards.png',
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
        $featuredCards = new FieldsBuilder('featured_cards');
        $featuredCards
            ->addRepeater('items', [
                'layout' => 'block',
                'collapsed' => 'title',
                'button_label' => 'Add Featured Card',
                'max' => '3',
            ])
            ->addImage('image', [
                'required' => 1
            ])
            ->addText('title', [
                'wrapper' => [
                    'width' => 40
                ],
                'required' => 1
            ])
            ->addText('sub_title', [
                'wrapper' => [
                    'width' => 60
                ],
                'required' => 1
            ])
            ->addLink('link', [
                'required' => 1
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
        
    }
}