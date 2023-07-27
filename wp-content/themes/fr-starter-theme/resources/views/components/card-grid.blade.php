<div class="container-fluid card-grid-container ajax-container" ajax-config="{{ $ajaxConfig }}" team-member-modal-config="{{ $teamMemberModalConfig }}" connected-filters="{{ json_encode($connectedFilters) }}" fr-status="{{ empty($posts)?'no-results-found':(!$hasMore?'no-more-results':'') }}">
    <div class="result-content ajax-content">
		<x-spinner />
		<div class="cards-container cards-inner atd-cards-container {{ count($posts) < 4 ? 'columns-'.count($posts) : 'columns-4' }}">
		@foreach ($posts as $card)
			{!! $card !!}
		@endforeach
		</div>
		<div class="load-btn-container wysiwyg-content">
			<x-cta-button label="{{ empty($loadMoreText) ? 'Load More' : $loadMoreText }}" type="external_url" external-url="javascript:void(0)" :arrow="false" style="secondary"/>
		</div>
		<div class="no-results-found-container wysiwyg-content">
			<h4>No results found.</h4>
			<p>Please update your search filters and try again.</p>
		</div>
				
		<div class="ajax-running-container wysiwyg-content">
			<span>loading...<span>
		</div>
    </div>
	@if(in_array('team-member', $postType))
		<x-team-member-modal />
	@endif
</div>