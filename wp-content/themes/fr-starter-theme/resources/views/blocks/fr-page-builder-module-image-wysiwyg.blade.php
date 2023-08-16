<div class="module image-wysiwyg-module {{ $block->classes }}"
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    <div class="container-fluid">
        <div class="row">
            @if ($image)
                <div class="col-4 col-12 image">
                    <img src="{{ $image['url'] }}" loading="lazy" class="img" />
                </div>
            @endif
            <div class="col wysiwyg-module">
                {!! $content !!}
            </div>
        </div>
    </div>
</div>
