<div class="module image-wysiwyg-module {{ $block->classes }}"
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    <div class="container-fluid">
        <div class="row">
            <div class="col image-wysiwyg-content">
                {!! $content !!}
            </div>
            <div class="col image">
                <div class="image">
                    <img src="{{ $image['url'] }}" />
                </div>
            </div>
        </div>
    </div>
</div>
