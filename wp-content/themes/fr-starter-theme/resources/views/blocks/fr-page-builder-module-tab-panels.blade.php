<div class="module tab-panels-module {{ $block->classes }}" fr-module-id="{{ $block->block->id }}" @if(isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
	@if ($block->preview)
		<div class="fr-module-controls p-2" fr-append-block-name="{{ $append_block_name }}">
			<div class="btn-toolbar mb-0" role="toolbar" aria-label="Toolbar with button groups">
				<div class="btn-group tab-pagination-container me-2" role="group" aria-label="First group">
				</div>
				<div class="btn-group me-2" role="group" aria-label="Second group">
					<button type="button" class="btn btn-secondary fr-add-tab-panel">+ Add Panel</button>
				</div>
			</div>
		</div>
	@else
		<style id="tab-panels-module-{{ $block->block->id }}">
			[fr-module-id="{{ $block->block->id }}"] > .tab-content > .tab-panel:first-of-type {
				display: block !important;
    			opacity: 1;
			}
		</style>
	@endif
	<div class="tab-content">
		<InnerBlocks orientation="horizontal" allowedBlocks='{{ $allowed_blocks }}'/>
	</div>
</div>
