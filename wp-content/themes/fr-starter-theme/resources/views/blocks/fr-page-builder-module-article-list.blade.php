<div class="module article-list-module {{ $block->classes }}"
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    <div class="container-fluid">
        @if ($items)
            <div class="accordion accordion-flush" id="acc-{{ $block->block->id }}">
                @forelse ($items as $i => $item)
                <div class="full-content wysiwyg-content">
                    <h4>{!! $item['title'] !!}</h4>
                    <div class="exerpt fr-truncate-text" fr-truncate-lines="2">
                    {!! $item['content'] !!}
                    </div>
                    <div class="hide-content">{!! $item['content'] !!}</div>
                    <button class="more-less">Read More</button>
                </div>
                
                @empty
                @endforelse
            </div>
        @endif
    </div>
</div>
