<div class="module logo-grid-module {{ $block->classes }}"
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    <div class="container-fluid">
        @if ($items)
            <div class="grid wysiwyg-content {{ count($items) <= 3 ? ' center-flex' : '' }}"
                id="logo-{{ $block->block->id }}">
                @forelse ($items as $i => $item)
                    <div class="img-container {{ count($items) > 3 ? ' four-col' : 'three-col' }}">
                        @if (isset($item['link']) && is_array($item['link']))
                            <a href="{{ $item['link']['url'] }}" target="{{ $item['link']['target'] }}">
                                <img src="{{ $item['logo_image']['url'] }}" alt="{{ $item['logo_image']['alt'] ?? '' }}"
                                    loading="lazy">
                            </a>
                        @else
                            <img src="{{ $item['logo_image']['url'] }}" alt="{{ $item['logo_image']['alt'] ?? '' }}"
                                loading="lazy">
                        @endif
                    </div>
                @empty
                @endforelse
            </div>
        @endif
    </div>
</div>
