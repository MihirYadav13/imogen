<div class="modal fade fr-modal team-member-modal" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<img src="@asset('images/close.svg')" alt="Close">
				</button>
			</div>
			<div class="modal-body">
				<x-spinner />
				<div class="member-info">
					{!! $modalBody !!}
				</div>
			</div>
		</div>
	</div>
</div>