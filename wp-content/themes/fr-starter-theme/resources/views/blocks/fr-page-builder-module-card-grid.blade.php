<div class="module card-grid-with-filter-module {{ $block->classes }}" @if(isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
	@if($blockData['post_type'] === 'student-success')
	<x-card-grid-filter :filter-id="$filterId" :filters="$frontendFilters" :includeSearch="true" :block-data="$blockData"/>
	@endif
	<x-card-grid :posts-per-page="$postsPerPage" :connected-filters="[$filterId]" :load-more-text="$loadMoreText" :block-data="$blockData"/>
</div>
