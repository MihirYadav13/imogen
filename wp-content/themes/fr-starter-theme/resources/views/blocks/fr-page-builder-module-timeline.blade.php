<div class="module timeline-module requires-splidejs {{ $block->classes }}" @if(isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
	<div class="container-fluid timeline-container">
		<div class="splide" role="group" aria-label="Timeline Slider" @if ($block->preview)
			style="visibility:visible;"
		@endif>
			<div class="splide__arrows arrow--left-side">
				<button class="splide__arrow splide__arrow--prev" @if ($block->preview)
					disabled="disabled"
				@endif>
					<div class="badge badge-dark-blue"></div>
				</button>
			</div>
			<div class="splide__track">
				<ul class="splide__list timeline-card-list">
					@foreach ($timeline_cards as $i => $card)						
						<li class="splide__slide timeline-slide {{ $i == 0 ? 'slide--first active-dot' : '' }} {{ $i == (count($timeline_cards) - 1) ? 'slide--last' : '' }}">
							<x-timeline-card :date="$card['card_data']['date']"
							:title="$card['card_data']['title']"
							:description="$card['card_data']['description']"
							:card-image="$card['card_image']"
							:modal-image="$card['modal_image']"
							:modal-content="$card['modal_content']"
							:index="$i"
							modal-id="{{ $block->block->id }}-timeline-modal"/>
							<div class="spacer"></div>
						</li>
					@endforeach
					<div class="animated-timeline-line">
						<div><span></span></div>
					</div>
				</ul>
			</div>
			<div class="splide__arrows arrow--right-side">
				<button class="splide__arrow splide__arrow--next">
					<div class="badge badge-dark-blue"></div>
				</button>
			</div>
		</div>
	</div>
	<div class="modal timeline-modal fade" id="{{ $block->block->id }}-timeline-modal" tabindex="-1" aria-labelledby="{{ $block->block->id }}-timeline-modal-label" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="buttons-container button--left">
					<button>
						<b class="badge badge-dark-blue"></b>
					</button>
				</div>
				<div class="modal-header">
					<button type="button" class="btn-close badge" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					Modal!
				</div>
				<div class="buttons-container button--right">
					<button>
						<b class="badge badge-dark-blue"></b>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>