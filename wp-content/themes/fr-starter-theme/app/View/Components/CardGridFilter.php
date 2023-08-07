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
		'age' => 'Age',
		'program' => 'Program',
		'activity' => 'Activity'
	];

	public $filtersPostType = [
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
	}
	

    public function getFilterData($filter){
		$result = [];

		$terms = \App\Providers\TaxonomyDataProvider::GetTerms($filter);

		$result = array_reduce($terms,function($res, $term) {
			$res[] = [
				'key' => $term['slug'],
				'value' => $term['name']
			];
			return $res;
		}, []);

		return $result;
	}


	public function setDefaultFilters(){
		$this->defaultFilters = array_merge($this->getArgsFromBlockData(), $this->getArgsFromUrl());
	}

	public function getArgsFromBlockData(){
        if(!$this->blockData){
            return [];
        }

        $taxonomies = $this->blockData['taxonomies'];

		if(!$taxonomies){
            return [];
        }

		return array_filter([
			'age' => \App\Providers\PostSearchProvider::GetTermsSlugs($taxonomies['age']?:[]),
			'activity' => \App\Providers\PostSearchProvider::GetTermsSlugs($taxonomies['activity']?:[]),
		]);
	}

    public function getArgsFromUrl(){
		return array_filter([
			'order_by' => filter_input(INPUT_GET, 'order_by')?: null,
			's' => filter_input(INPUT_GET, 's')?: null,
			'age' => filter_input(INPUT_GET, 'age', FILTER_UNSAFE_RAW)? explode(',', filter_input(INPUT_GET, 'age', FILTER_UNSAFE_RAW)): null,
			'activity' => filter_input(INPUT_GET, 'activity', FILTER_UNSAFE_RAW)? explode(',', filter_input(INPUT_GET, 'activity', FILTER_UNSAFE_RAW)): null,
		]);
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