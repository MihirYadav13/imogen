<div class="module card-grid-with-filter-module {{ $block->classes }}"
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    @if (in_array('post', $blockData['post_type']))
        <div class="container-fluid">
            <div class="col wysiwyg-heading-content wysiwyg-content">
                {!! $heading_content !!}
            </div>
        </div>
        <x-card-grid-filter :filter-id="$filterId" :filters="$frontendFilters" :includeSearch="true" :block-data="$blockData" />
    @endif
    <x-card-grid :posts-per-page="$postsPerPage" :connected-filters="[$filterId]" :load-more-text="$loadMoreText" :block-data="$blockData" :show-no-result="in_array('post', $blockData['post_type'])" />
</div>
