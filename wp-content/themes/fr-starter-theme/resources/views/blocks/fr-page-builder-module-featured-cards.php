<div class="module featured-cards-module {{ $block->classes }}"
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    <div class="container-fluid">
        @if ($items)
            <div class="featured-cards-parent" id="sc-{{ $block->block->id }}">
                @forelse ($items as $i => $item)
                    <div class="featured-cards-item">
                        <div class="card-image">
                            <img src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] ?? '' }}" loading="lazy">
                        </div>
                        <div class="featured-cards-inner-content">
                            <h5 class="card-title">{!! $item['title'] !!}</h5>
                            <h6 class="card-sub-title">{!! $item['sub_title'] !!}</h6>
                        </div>
                        <a href="{{ $item['link']['url'] }}"
                            target="{{ $item['link']['target'] }}"class="icon cta-button ">LEARN
                            MORE<b></b></a>
                    </div>
                @empty
                @endforelse
            </div>
        @endif
    </div>
</div>