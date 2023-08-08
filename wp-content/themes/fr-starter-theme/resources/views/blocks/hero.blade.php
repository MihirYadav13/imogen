@php
    $is_front_page_hero = 'yes' == get_field('is_front_page_hero');
    $not_front_class = $is_front_page_hero ? '' : 'not-front';
@endphp

<div class="fr-hero hero {{ $not_front_class }} {{ $block->classes }}">
    @include('components.responsive-acf-image', [
        'image' => $background_image,
        'class' => 'hero-bg-image desktop',
    ])
    @include('components.responsive-acf-image', [
        'image' => $background_image_mobile,
        'class' => "hero-bg-image mobile $not_front_class",
    ])

    <div class="content-container {{ $not_front_class }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 content-col wysiwyg-content">
                    {!! $content !!}
                </div>
            </div>
        </div>
    </div>
</div>
