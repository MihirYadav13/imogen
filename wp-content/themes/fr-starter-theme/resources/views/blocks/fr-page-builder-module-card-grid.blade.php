<div class="module card-grid-module {{ $block->classes }}" @if(isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
  <div class="container-fluid card-grid-container">
    @forelse ($cards as $card)
      @if ($source == 'manual')
        <x-project-card :preview="$block->preview" :title="$card['title']" :description="$card['description']" :image="$card['image']" :link="$card['link']" :tag="$card['tag']"/>
      @else
        <x-project-card :preview="$block->preview"  :title="$card['title']" :description="$card['excerpt']" :image="$card['image']" :link="$card['permalink']" :tag="$card['tag']"/>
      @endif
    @empty
    @endforelse
  </div>
</div>
