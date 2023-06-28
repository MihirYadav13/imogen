<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class CardGrid extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Card Grid';

	/**
	 * The block slug.
	 *
	 * @var string
	 */
	public $slug = 'fr-page-builder-module-card-grid';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Card Grid block.';

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
    public $icon = ' fricon fricon--card-grid';

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
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        return $this->items();
    }

    public $example = [
        'cards' => [
            [
                'tag' => 'United States',
                'image' => [
                    'url' => 'https://via.placeholder.com/500',
                    'alt' => 'Placeholder image'
                ],
                'title' => 'Test Card',
                'description' => 'This is just a test. Start editing content for this block.',
                'link' => [
                    'title' => 'Click me',
                    'url' => 'javascript:void(0)',
                    'target' => ''
                ]
            ]
        ],
        'source' => 'manual'
    ];

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        $cardGrid = new FieldsBuilder('card_grid');

        $cardGrid
            ->addRadio('source', [
                'choices' => [
                    'manual' => 'Manually Entered Content',
                    'posts' => 'Select from Project Posts',
                    'from_filters' => 'Dynamically Pulled from Filters',
                ],
                'wpml_cf_preferences' => 0,
                'layout' => 'horizontal',
                'default_value' => 'manual'
            ])
            ->addRepeater('cards', [
                'max' => 3,
                'layout' => 'block',
                'collapsed' => 'title',
                'wrapper' => [
                    'class' => 'repeat-horizontal'
                ]
            ])
                ->conditional('source', '==', 'manual')
                ->addText('tag', [
                    'label' => 'Label'
                ])
                ->addImage('image')
                ->addText('title')
                ->addTextarea('description', [
                    'rows' => 3
                ])
                ->addLink('link')
            ->endRepeater()
            ->addRepeater('projects', [
                'layout' => 'block',
                'max' => 3
            ])
                ->conditional('source', '==', 'posts')
                ->addPostObject('project', [
                    'post_type' => [
                        'project'
                    ],
                    'required' => 1
                ])
            ->endRepeater()
            ->addGRoup('filters', [
                'layout' => 'block',
            ])
                ->conditional('source', '==', 'from_filters')
                ->addTaxonomy('region', [
                    'label' => 'Region',
                    'taxonomy' => 'region',
                    'field_type' => 'radio',
                    'add_term' => 0,
                    'save_terms' => 0,
                    'load_terms' => 0,
                    'multiple' => 0,
                    'allow_null' => 1,
                    'return_format' => 'object',
                    'wrapper' => [
                        'width' => 50
                    ]
                ])
                ->addTaxonomy('services', [
                    'label' => 'Project Type(s)',
                    'taxonomy' => 'service',
                    'field_type' => 'multi_select',
                    'add_term' => 0,
                    'save_terms' => 0,
                    'load_terms' => 0,
                    'multiple' => 1,
                    'allow_null' => 1,
                    'return_format' => 'object',
                    'wrapper' => [
                        'width' => 50
                    ]
                ])
                ->addNumber('card_count', [
                    'min' => 1,
                    'default_value' => 3
                ])
            ->endGroup();

        return $cardGrid->build();
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function items()
    {

        $cards = [];
        $source = get_field('source');

        switch ($source) {
            case 'manual':
                $cards = get_field('cards') ?: $cards;
                break;
            case 'posts':
                $cards = $this->generateCardDataFromPostArray(get_field('projects'));
                break;
            case 'from_filters':
                $cards = $this->getCardsFromFilters(get_field('filters'));
                break;
            default:
                break;
        }

        $result =  [
            'cards' => $cards,
            'source' => get_field('source')
        ];

        if($this->preview && count($result['cards']) == 0){
            $result = $this->example;
        }

        return $result;
    }

    public function getCardsFromFilters($filters){
        $result = [];

		$args = [
			'post_type' => 'project',
			'posts_per_page' => $filters['card_count'] ?: 3,
			'region' => $filters['region'] ? [$filters['region']->slug] : false,
			'service' => array_column($filters['services']?: [], 'slug'),
		];

        $posts = \App\Providers\PostSearchProvider::GetPosts($args);

        foreach($posts?: [] as $p){
            $result[] = \App\Providers\CardsDataProvider::get($p);
        }

        return $result;
    }

    public function generateCardDataFromPostArray($post_arr = []){
        $result = [];
        foreach ($post_arr ?: [] as $i) {
            $result[] = \App\Providers\CardsDataProvider::get($i['project']);
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
