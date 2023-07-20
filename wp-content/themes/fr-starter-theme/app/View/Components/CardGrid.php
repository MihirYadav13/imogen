<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardGrid extends Component
{

    public $queryArgs;
    public $posts;
	public $hasMore;
	public $ajaxConfigArgs;
    public $ajaxConfig;
    public $connectedFilters;
	public $postsPerPage = \App\Providers\PostSearchProvider::POSTS_PER_PAGE;
	public $postType = \App\Providers\PostSearchProvider::GENERAL_SEARCH_POST_TYPES;
    public $loadMoreText;
    public $includePublishCard;
    public $blockData;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($postsPerPage = false, $postType = false, $ajaxConfig = false, $connectedFilters = [], $loadMoreText = 'Load More', $includePublishCard = false, $blockData = false)
    {
        $this->posts = [];
        $this->postsPerPage = $postsPerPage ? : $this->postsPerPage;
		$this->postType = $postType ? : $this->postType;
        $this->connectedFilters = $connectedFilters;
        $this->loadMoreText = $loadMoreText;
        $this->includePublishCard = $includePublishCard ? json_decode($includePublishCard) : false;
        $this->blockData = $blockData;

        $this->setQueryArgs();
        $this->preparePosts();

        $this->setAjaxConfigArgs();
		$this->prepareAjaxConfig();
    }


    public function setQueryArgs(){
		$this->queryArgs = array_merge([
            'post_type' => $this->postType,
			'posts_per_page' => $this->postsPerPage,
		], $this->getArgsFromBlockData(), $this->getArgsFromUrl());
	}


    public function setAjaxConfigArgs(){
		$this->ajaxConfigArgs = [
			'block_name' => 'card_grid_component',
			'source' => 'filters',
			'post_types' => $this->postType,
			'posts_per_page' => $this->postsPerPage,
		];

        if($this->blockData){
            $this->ajaxConfigArgs = array_merge($this->ajaxConfigArgs, $this->blockData);
        }
	}

    public function getArgsFromBlockData(){
        if(!$this->blockData){
            return [];
        }

        $taxonomies = $this->blockData['taxonomies'];

        $args = [
			'post_type' => $this->blockData['post_type'],
		];

        if(!$taxonomies){
            return $args;
        }

		return array_merge($args, [
			'age' => \App\Providers\PostSearchProvider::GetTermsSlugs($taxonomies['age']?:[]),
			'program' => \App\Providers\PostSearchProvider::GetTermsSlugs($taxonomies['program']?:[]),
		]);
	}

    public function getArgsFromUrl(){
		return array_filter([
			'order_by' => filter_input(INPUT_GET, 'order_by')?: null,
			's' => filter_input(INPUT_GET, 's')?: null,
			'age' => filter_input(INPUT_GET, 'age', FILTER_UNSAFE_RAW)? explode(',', filter_input(INPUT_GET, 'age', FILTER_UNSAFE_RAW)): null,
			'program' => filter_input(INPUT_GET, 'program', FILTER_UNSAFE_RAW)? explode(',', filter_input(INPUT_GET, 'program', FILTER_UNSAFE_RAW)): null,
		]);
	}

	/**
     * Prepare posts data.
     *
     * @return void
     */
    public function preparePosts(){
		$result = \App\Providers\PostSearchProvider::GetPosts($this->queryArgs);

		$this->posts = \App\Providers\PostSearchProvider::ConvertDataToHtmlArray($result['posts']);
		$this->hasMore = $result['hasMore'];
	}

	/**
     * Prepare ajax config.
     *
     * @return void
     */
	public function prepareAjaxConfig(){
		$this->ajaxConfig = \App\Providers\PostSearchProvider::getAjaxConfig($this->ajaxConfigArgs);
	}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card-grid');
    }
}
