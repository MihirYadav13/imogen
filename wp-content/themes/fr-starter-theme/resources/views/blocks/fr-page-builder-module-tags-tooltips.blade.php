<div class="module tags-with-tooltips-module {{ $block->classes }}" @if(isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
  <div class="container-fluid tags-container">
    @forelse ($tags as $t)
        <button class="tag {{ strlen($t['description']) > 0 ? 'has-desc' : '' }}  {{ isset($t['link']) && is_array($t['link']) ? 'has-link' : '' }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" data-bs-title="{{ $t['description'] }}" data-bs-custom-class="rn-tooltip rn-tooltip-start-hidden" trigger="manual">
          @if (isset($t['link']) && is_array($t['link']))
            <a href="{{ $t['link']['url'] }}" target="{{ $t['link']['target'] }}">{!! $t['label'] !!}</a>  
          @else
            {!! $t['label'] !!}
          @endif
        </button>
    @empty
    @endforelse
  </div>
</div>