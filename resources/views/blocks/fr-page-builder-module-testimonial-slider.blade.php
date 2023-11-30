<div class="module testimonial-content-module {{ $block->classes }}"
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    <div class="container-fluid testimonial-content-container wysiwyg-content requires-splidejs">
        {{-- <div class="testimonial splide" style="visibility:visible;"> --}}
        {{-- <div class="splide__track">
                <ul class="splide__list"> --}}
        <li>
            @if ($image)
                <div class="image">
                    <img src="{{ $image['url'] }}" loading="lazy" class="img" />
                </div>
            @endif


            <div class="left">
            <div class="testimonial_content">< {!! $testimonial_content !!}</div>
            <div class="col wysiwyg-module">
                {!! $organization !!}
            </div> </div>
        </li>
        {{-- </ul>
            </div> --}}
        {{-- </div> --}}
    </div>
</div>
