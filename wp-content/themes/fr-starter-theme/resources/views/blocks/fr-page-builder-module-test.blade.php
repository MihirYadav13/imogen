@php
    $flip_class = '';
    $image_size_class = '';
    $description_size_class = '';
    
    if ($image_size === '1/3') {
        $image_size_class = 'size_1_3';
        $description_size_class = 'size_2_3';
    } elseif ($image_size === '1/2') {
        $image_size_class = 'size_1_2';
        $description_size_class = 'size_1_2';
    } elseif ($image_size === '2/3') {
        $image_size_class = 'size_2_3';
        $description_size_class = 'size_1_3';
    }
    
    if ($flip_orientation) {
        $flip_class = 'flip';
    }
@endphp

<div class="module test-module {{ $block->classes }}"
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    <div class="container-fluid">
        <div class="row-test {{ $flip_class }}">
            @if ($image)
                <div class="col-4 col-12 image {{ $image_size_class }}">
                    <img src="{{ $image['url'] }}" loading="lazy" class="img" />
                </div>
            @endif
            <div class="col wysiwyg-module {{ $description_size_class }}">
                {!! $content !!}
            </div>
        </div>
    </div>
</div>
