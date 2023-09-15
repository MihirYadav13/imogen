@if($contact_form)
<div class="module contact-form-module {{ $block->classes }}" @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
    @include('components.grid-heading-content')
    <div class="form-container">{!! $contact_form !!}</div>
</div>
@elseif($block->preview)
    <div class="fr-empty-slot">
        <i>Please select form to show view.</i>
    </div>
@endif
