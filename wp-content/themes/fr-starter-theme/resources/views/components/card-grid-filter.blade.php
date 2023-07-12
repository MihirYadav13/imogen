<div class="card-filter-component">
	<form action="javascript:void(0);" method="get" class="filter-form" id="{{ $filterId }}" form-elements="{{ json_encode(array_values($formElements)) }}">
		<div class="filter-input-col taxonomy-filters">
			<label class="col-label">
				Filter By:
			</label>
			<div class="filter-container">
				@foreach($taxonomyFilters as $filter => $options)
					@include('forms.filter.select', ['filter' => $filter, 'options' => $options])
				@endforeach
				@if($includeSearch)
					@include('forms.filter.search', [])
				@endif
			</div>
		</div>
		<div class="filter-input-col sort-by-filters">
			@if($showSortBy)
				<label class="col-label">
					Sort By:
				</label>
				<div class="filter-container">
					@include('forms.filter.sort-filters', [])
				</div>
			@endif
			<div class="reset-filters-container">
				<x-cta-button label="Reset filters" type="external_url" style="regular-link" external-url="javascript:void(0)" />
			</div>
		</div>
	</form>
</div>
