<div class="card-filter-component">
	<form action="javascript:void(0);" method="get" class="filter-form" id="{{ $filterId }}" form-elements="{{ json_encode(array_values($formElements)) }}">
		<div class="filter-input-col taxonomy-filters">
			<div class="filter-container">
				@foreach($taxonomyFilters as $filter => $options)
					@if($filter === 'programs')
						@include('forms.filter.select-with-group', ['filter' => $filter, 'options' => $options])
					@else
						@include('forms.filter.select', ['filter' => $filter, 'options' => $options])
					@endif
				@endforeach
				@if($includeSearch)
					@include('forms.filter.search', [])
				@endif
			</div>
		</div>
	</form>
</div>
