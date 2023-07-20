<div class="search-container filter-input">
	<h6>Search</h6>
	<div class="input-container">
		<label for="{{ $searchId }}">
			<input type="text" name="s" placeholder="Search" id="{{ $searchId }}">
		</label>
		@include('partials.search-button', ['attr' => 'type="submit"', 'extra_class' => ''])
	</div>
</div>