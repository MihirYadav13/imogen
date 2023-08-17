<div class="module manual-card-grid-module {{ $block->classes }}" @if(isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
	<div class="container-fluid card-grid-container ajax-container">
		<div class="result-content ajax-content">
			<div class="cards-container cards-inner {{ count($items) < 4 ? 'columns-'.count($items) : 'columns-4' }}">
				@foreach ($items as $card_data)
					<div class="fr-card card-type-manual" >
						<div class="card-inner">
							<div class="featured-image">
								<img src="{{ $card_data['featured_image']['url'] }}" loading="lazy" alt="Featured">
							</div>
							<div class="card-content">
								<div class="wysiwyg-content">
									<div class="card-header">
										<a href="{{ $card_data['cta_link']['url'] }}" class="card-link">
											<h5 class="card-title" fr-truncate-lines="3" title="{{ $card_data['title'] }}">
												{!! $card_data['title'] !!}
											</h5>
										</a>
									</div>
									<div class="card-body">                    
										<p class="excerpt sm" fr-truncate-lines="4" title=""> {!! $card_data['description'] !!} </p>
									</div>                
									<div class="card-footer"> 
										<x-cta-button :label="$card_data['cta_link']['title']?:'Learn More'" :external-url="$card_data['cta_link']['url']" type="external_url" :style="'regular-link'" />
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>			
		</div>		
	</div>	
</div>
 