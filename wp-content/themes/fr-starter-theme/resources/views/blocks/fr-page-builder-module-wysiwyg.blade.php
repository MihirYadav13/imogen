@php
    $bottom_spacing_class = '';
    
    if ($bottom_spacing === 'zero') {
        $bottom_spacing_class = 'zero-space';
    } elseif ($bottom_spacing === 'heading') {
        $bottom_spacing_class = 'heading-space';
    } elseif ($bottom_spacing === 'module') {
        $bottom_spacing_class = 'module-space';
    }
@endphp

<div class="module wysiwyg-module {{ $block->classes }} {{ $bottom_spacing_class }}"
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    <div class="container-fluid">
        <div class="row">
            <div class="col wysiwyg-content">
                {!! $content !!}
            </div>
        </div>
    </div>
</div>
