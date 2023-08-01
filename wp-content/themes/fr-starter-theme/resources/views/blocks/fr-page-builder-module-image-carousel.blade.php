<div class="module image-carousel-module {{ $block->classes }}"
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
	@if ($images)
    <div class="container-fluid image-carousel-container wysiwyg-content requires-splidejs">
		<div class="image-carousel splide" style="visibility:visible;">
			<div class="splide__track">
				<ul class="splide__list">
				@forelse ($images as $i => $image)
					<li class="splide__slide"><img src="{{ $image['url'] }}" loading="lazy"></li>
				@empty
          		@endforelse
				</ul>
			</div>
		</div>
		<div class="thumbnail-carousel splide" style="visibility:visible;">
			<div class="splide__track">
				<ul class="splide__list">
					@forelse ($images as $i => $image)
						<li class="splide__slide"><img src="{{ $image['url'] }}" loading="lazy"></li>
					@empty
          			@endforelse
				</ul>
			</div>
		</div>
	</div>
	@endif
</div>