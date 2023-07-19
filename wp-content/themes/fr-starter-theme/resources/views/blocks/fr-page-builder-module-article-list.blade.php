<div class="module article-list-module {{ $block->classes }}"
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    <div class="container-fluid">
        @if ($items)
            <div class="accordion accordion-flush" id="acc-{{ $block->block->id }}">
                @forelse ($items as $i => $item)
                <div class="full-content">
                    <h3>{!! $item['title'] !!}</h3>
                    <div class="if_exerpt fr-truncate-text" fr-truncate-lines="2">
                    <p>{!! $item['content'] !!}</p>
                    </div>
                    <div class="hide-content"><p>{!! $item['content'] !!}</p></div>
                    <button class="more-less">Read More</button>
                </div>
                @empty
                @endforelse
            </div>
        @endif
    </div>
</div>
