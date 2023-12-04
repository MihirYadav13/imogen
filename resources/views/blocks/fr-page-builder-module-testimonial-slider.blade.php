<div class="module testimonial-content-module {{ $block->classes }}" @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    {{-- <div class="container-fluid testimonial-content-container wysiwyg-content requires-splidejs">
    <div class="testimonial splide" style="visibility:visible;">
    <div class="splide__track">
                <ul class="splide__list"> --}}

    <div class="parent_content">
        <div class="child_content">
            <div class="right">
                @if ($image)
                <div class="image_ts_module">
                    <img src="{{ $image['url'] }}" loading="lazy" class="img" />
                </div>
            </div>
            @endif


            <div class="left">
                <div class="testimonial_content">{!! $testimonial_content !!}</div>
                <div class="testimonial_title">{!! $title !!}</div>
                <div class="col wysiwyg-module">
                    {!! $organization !!}
                </div>

                {{-- </ul>
            </div> --}}
                {{-- </div> --}}
            </div>
