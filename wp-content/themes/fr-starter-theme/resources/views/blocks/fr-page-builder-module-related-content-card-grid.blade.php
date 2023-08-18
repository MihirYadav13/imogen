<div class="module related-content-card-grid-with-filter-module {{ $block->classes }}" @if(isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
	<x-card-grid :posts-per-page="$postsPerPage" :connected-filters="[$filterId]" :load-more-text="$loadMoreText" :block-data="$blockData"/>
</div>
