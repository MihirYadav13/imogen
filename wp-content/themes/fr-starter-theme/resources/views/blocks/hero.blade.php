<div class="fr-hero hero {{ $block->classes }}">
    @include('components.responsive-acf-image', [
        'image' => $background_image,
        'class' => 'hero-bg-image desktop',
    ])
    @include('components.responsive-acf-image', [
        'image' => $background_image_mobile,
        'class' => 'hero-bg-image mobile',
    ])

    <div class="content-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 content-col wysiwyg-content">
                    {!! $content !!}
                </div>
            </div>
        </div>
    </div>
</div>
