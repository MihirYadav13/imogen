<div class="module tabs-module {{ $block->classes }} {{ $sticky_on_scroll ? 'fr-sticky-on-scroll' : '' }}" fr-tabs-mode="{{ $mode }}"  @if(isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
	<div class="container-fluid">
		@if ($items)
			<ul class="tabs" role="tablist">
				@foreach ($items as $i => $item)
					<li class="{{ $i === 0 ? 'active' : '' }}" id="{{ $item['item_id'] }}-tab" {{ $mode == 'tabs' ? "data-bs-toggle=tab data-bs-target=#".$item['item_id']."-pane aria-controls=".$item['item_id']."-pane" : 'fr-anchor-id='.$item['item_id'] }} type="button" role="tab" aria-selected="{{ $i === 0 ? 'true' : 'false' }}">
						<a href="javascript:void(0)">{{ $item['item_label'] }}</a>
					</li>
				@endforeach
			</ul>
			@if ($sticky_on_scroll)				
				<button class="mobile-toggle-options">
					<b></b>
				</button>
			@endif
		@endif
	</div>
</div>