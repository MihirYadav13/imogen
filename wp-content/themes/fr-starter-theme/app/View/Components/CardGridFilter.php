<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardGridFilter extends Component
{

    public $filterId;
    public $includeSearch;
    public $searchId;
    public $showSortBy;
    public $taxonomyFilters;
    public $sortFilters;
    public $filters;
	public $formElements = [];
	public $defaultFilters = [];
	public $blockData;

    public $taxonomyFilterLabels = [
		'resource-type' => 'Resource Type',
		'keyword-tag' => 'Keyword Tag',
		'selected_topics' => 'Topic',
		'related_strategies' => 'Strategy'
	];

	public $filtersPostType = [
		'selected_topics' => 'topic',
		'related_strategies' => 'strategy'
	];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($filterId, $includeSearch = false, $showSortBy = true, $filters = [], $blockData = false)
    {
        $this->filterId = $filterId ?: uniqid('card-grid-filter_');
        $this->includeSearch = $includeSearch;
        $this->searchId = uniqid('search-input_');
        $this->showSortBy = $showSortBy;
        $this->taxonomyFilters = [];
        $this->filters = $filters;
		$this->blockData = $blockData;
		$this->formElements = array_filter(
			array_merge($this->filters, [
				$includeSearch ? 's' : null,
				$showSortBy ? 'order_by' : null,
			])
		);

        $this->prepareFilters();
		$this->setDefaultFilters();
    }

    public function prepareFilters(){
		foreach($this->filters as $filter){
            $this->taxonomyFilters[$filter] = $this->getFilterData($filter);
        }

        $this->sortFilters = $this->GetSortFilters();
	}
	

    public function getFilterData($filter){
		$result = [];

		if(in_array($filter, ['resource-type', 'keyword-tag'])){
			$terms = \App\Providers\TaxonomyDataProvider::GetTerms($filter);

			$result = array_reduce($terms,function($res, $term) {
				$res[] = [
					'key' => $term['slug'],
					'value' => $term['name']
				];
				return $res;
			}, []);
		}
		else {
			$args = [
				'post_type' => [$this->filtersPostType[$filter]],
				'posts_per_page' => 0,
				'post_status' => ['publish']
			];

			$posts = \App\Providers\PostSearchProvider::GetPosts($args);

			$result = array_reduce($posts['posts'],function($res, $post) {
				$res[] = [
					'key' => $post->ID,
					'value' => $post->post_title
				];
				return $res;
			}, []);
		}

		return $result;
	}


	public function setDefaultFilters(){
		$this->defaultFilters = array_merge($this->getArgsFromBlockData(), $this->getArgsFromUrl());
	}

	public function getArgsFromBlockData(){
        if(!$this->blockData){
            return [];
        }

        $filtersConfiguration = $this->blockData['filters_configuration'];

		return array_filter([
			'resource-type' => \App\Providers\PostSearchProvider::GetTermsSlugs($filtersConfiguration['taxonomies']['resource-type']),
			'keyword-tag' => \App\Providers\PostSearchProvider::GetTermsSlugs($filtersConfiguration['taxonomies']['keyword-tag']),
			'selected_topics' => $filtersConfiguration['taxonomies']['topic']?:null,
			'related_strategies' => $filtersConfiguration['taxonomies']['strategy']?:null
		]);
	}

    public function getArgsFromUrl(){
		return array_filter([
			'order_by' => filter_input(INPUT_GET, 'order_by')?: null,
			's' => filter_input(INPUT_GET, 's')?: null,
			'resource-type' => filter_input(INPUT_GET, 'resource-type', FILTER_UNSAFE_RAW)? explode(',', filter_input(INPUT_GET, 'resource-type', FILTER_UNSAFE_RAW)): null,
			'keyword-tag' => filter_input(INPUT_GET, 'keyword-tag', FILTER_UNSAFE_RAW)? explode(',', filter_input(INPUT_GET, 'keyword-tag', FILTER_UNSAFE_RAW)): null,
			'selected_topics' => filter_input(INPUT_GET, 'selected_topics', FILTER_UNSAFE_RAW)? explode(',', filter_input(INPUT_GET, 'selected_topics', FILTER_UNSAFE_RAW)): null,
			'related_strategies' => filter_input(INPUT_GET, 'related_strategies', FILTER_UNSAFE_RAW)? explode(',', filter_input(INPUT_GET, 'related_strategies', FILTER_UNSAFE_RAW)): null,
		]);
	}


    /**
     * Get sort filters.
     *
     * @return array
     */
	public static function GetSortFilters()
    {		
        return [
			[
				'input_name' => 'order_by',
				'label' => 'Latest',
				'value' => 'latest'
			],
			[
				'input_name' => 'order_by',
				'label' => 'Most Popular',
				'value' => 'popular'
			]
		];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card-grid-filter');
    }
}
