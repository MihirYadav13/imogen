<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.0.9/dist/css/splide.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.0.9/dist/js/splide.min.js"></script>

<div class="module testimonial-content-module {{ $block->classes }}" @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    <div class="container-fluid testimonial-content-container wysiwyg-content requires-splidejs">
        <div class="testimonial-slider splide" style="visibility:visible;">
            <div class="splide__track">
                <ul class="splide__list">
                <div class=“parent_content”>
                    <li class="splide__slide">
                        <div class="child_content">
                            <div class="right">
                                @if ($image)
                                    <img src="{{ $image['url'] }}" loading="lazy" class="img">
                                @endif
                            </div>
                            <div class="left">
                                <div class="testimonial_content">{!! $testimonial_content !!}</div>
                                <div class="testimonial_title">{!! $title !!}</div>
                                <div class="col wysiwyg-module">
                                    {!! $organization !!}
                                </div>
                            </div>

                        </div>
                    </li>
                    <li class="splide__slide">
                    <div class="child_content">
                            <div class="right">
                                @if ($image)
                                    <img src="{{ $image['url'] }}" loading="lazy" class="img">
                                @endif
                            </div>
                            <div class="left">
                                <div class="testimonial_content">{!! $testimonial_content !!}</div>
                                <div class="testimonial_title">{!! $title !!}</div>
                                <div class="col wysiwyg-module">
                                    {!! $organization !!}
                        <!-- Content for the second slide goes here -->
                    </li>
                    <!-- Add more slides as needed -->
                </ul>
            </div>

        </div>
    </div>
</div>

