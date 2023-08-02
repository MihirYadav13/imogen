<div class="card-filter-component">
	<form action="javascript:void(0);" method="get" class="filter-form" id="{{ $filterId }}" form-elements="{{ json_encode(array_values($formElements)) }}">
		<div class="filter-input-col taxonomy-filters">
			<div class="filter-container">
				@foreach($taxonomyFilters as $filter => $options)
					@include('forms.filter.select', ['filter' => $filter, 'options' => $options])
				@endforeach
				@if($includeSearch)
					@include('forms.filter.search', [])
				@endif
			</div>
		</div>
	</form>
</div>
