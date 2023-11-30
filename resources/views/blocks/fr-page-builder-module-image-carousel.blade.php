<!-- @if ($images)
@php
$is_post = is_page() ? 'is__page' : 'is__post';
@endphp
<div class="module image-carousel-module {{ $block->classes }}"
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
	
    <div class="container-fluid image-carousel-container wysiwyg-content requires-splidejs">
		<div class="image-carousel splide" style="visibility:visible;">
			<div class="splide__track">
				<ul class="splide__list">
				@forelse ($images as $i => $image)
					<li class="splide__slide "><img src="{{ $image['url'] }}" loading="lazy"></li>
				@empty
          		@endforelse
				</ul>
			</div>
		</div>
		<div class="thumbnail-carousel splide" style="visibility:visible;">
			<div class="splide__track">
				<ul class="splide__list @if (count($images) < 5) justify @endif " >
					@forelse ($images as $i => $image)
						<li class="splide__slide {{ $is_post }}"><img src="{{ $image['url'] }}" loading="lazy"></li>
					@empty
          			@endforelse
				</ul>
			</div>
		</div>
	</div>	
</div>
@endif -->
@if ($images)
    @php
        $is_post = is_page() ? 'is__page' : 'is__post';
    @endphp

    <div class="module testimonial-content-module {{ $block->classes }}" @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
        <div class="container-fluid testimonial-content-container wysiwyg-content requires-splidejs">
            <div class="testimonial-content splide" style="visibility:visible;">
                <div class="splide__track">
                    <ul class="splide__list">
                        @forelse ($images as $image)
                            <li class="splide__slide">
                                <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" loading="lazy">
                            </li>
                        @empty
                            <!-- Handle case when there are no images -->
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="thumbnail-carousel splide" style="visibility:visible;">
                <div class="splide__track">
                    <ul class="splide__list @if (count($images) < 5) justify @endif">
                        @forelse ($images as $image)
                            <li class="splide__slide {{ $is_post }}">
                                <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" loading="lazy">
                            </li>
                        @empty
                            <!-- Handle case when there are no thumbnail images -->
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="testimonial-details">
                @if(isset($testimonial_content))
                    <div class="testimonial-content">
                        {!! $testimonial_content !!}
                    </div>
                @endif

                @if(isset($organization))
                    <div class="organization">
                        <p>{{ $organization }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
