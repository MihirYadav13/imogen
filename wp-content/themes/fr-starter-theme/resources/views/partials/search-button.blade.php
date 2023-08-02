<button class="search-btn {{ isset($extra_class) ? $extra_class : '' }} {{ isset($has_dropdown) && $has_dropdown ? 'has-search-dropdown' : '' }}" {!! isset($attr) ? $attr : '' !!}>
	@if (isset($has_dropdown) && $has_dropdown)
		<img class="search-icon" src="@asset('images/search.svg')"/>
		<img class="close-icon" src="@asset('images/close.svg')"/>
	@endif
</button>