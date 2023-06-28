<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class TagsTooltips extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Tags Tooltips';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A simple Tags Tooltips block.';

	/**
	 * The block slug.
	 *
	 * @var string
	 */
	public $slug = 'fr-page-builder-module-tags-tooltips';

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
        'tags' => [
            [
                'label' => 'Test Tag 1',
                'description' => '<p>This is a test description</p>'
            ],
            [
                'label' => 'Test Tag 2',
                'description' => '<p>This is a test description</p>'
            ],
            [
                'label' => 'Test Tag 3',
                'description' => '<p>This is a test description</p>'
            ]
        ],
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        $result = [
            'tags' => get_field('source') == 'services' ? $this->formatTaxonomyToTags(get_field('services')) : $this->items() 
        ];

        if($this->preview && (!$result['tags'] || !is_array($result['tags']))){
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
        $tagsTooltips = new FieldsBuilder('tags_tooltips');

        $tagsTooltips
            ->addRadio('source', [
                'choices' => [
                    'manual' => 'Manually Entered Content',
                    'services' => 'Select From Project Type Taxonomy'
                ],
                'wpml_cf_preferences' => 0,
                'layout' => 'horizontal',
                'default_value' => 'manual'
            ])
            ->addRepeater('tags', [
                'layout' => 'block'
            ])
                ->conditional('source', '==', 'manual')
                ->addText('label')
                ->addTextarea('description', [
                    'rows' => '3'
                ])
                ->addLink('link')
            ->endRepeater()
            ->addTaxonomy('services', [
                'label' => 'Project Types',
                'taxonomy' => 'service',
                'field_type' => 'multi_select',
                'add_term' => 0,
                'save_terms' => 0,
                'load_terms' => 0,
                'multiple' => 1,
                'return_format' => 'object'
            ])
                ->conditional('source', '==', 'services');

        return $tagsTooltips->build();
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function items()
    {
        $tags = [];
        foreach (get_field('tags') ?: [] as $t) {
            $tags[] = [
                'label' => $t['label'],
                'description' => htmlentities($t['description']),
                'link' => $t['link']
            ];
        }

        return $tags;
    }

    public function formatTaxonomyToTags($services){
        $tags = [];

        foreach ($services ?: [] as $t) {
            $tags[] = [
                'label' => $t->name,
                'description' => htmlentities($t->description),
                'link' => get_field('tag_link', 'service_' . $t->term_id) 
            ];
        }

        return $tags;
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
