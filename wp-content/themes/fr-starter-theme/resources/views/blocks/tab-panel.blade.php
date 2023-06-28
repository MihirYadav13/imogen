<div class="tab-panel {{ $block->classes }} tab-pane {{ $block->preview ? '' : 'fade' }}" id="{{ $tab_panel_id }}-pane" role="tabpanel" aria-labelledby="{{ $tab_panel_id }}-tab" tabindex="0">
  @if ($block->preview)
    <div class="fr-empty-slot"></div>
  @endif
  <InnerBlocks allowedBlocks='{{ $allowed_blocks }}'/>
</div>