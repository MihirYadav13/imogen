<div class="module image-wysiwyg-module {{ $block->classes }}"
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    <div class="container-fluid">
        <div class="row">
            <div class="col image-wysiwyg-content">
                {!! $content !!}
            </div>
            @if($image)
                <div class="col image">
                    <div class="image">
                        <img src="{{ $image['url'] }}" loading="lazy"/>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
