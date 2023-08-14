<div class="fr-share-button">
	<h6 class="share-txt">Share:</h6>
	<div class="share-dialog">
		@if ($links && is_array($links))
			<ul class="social-sharing-links">
				@foreach ($links as $l)
					<li>
						<a class="share-btn {{ $l['class'] }}" href="{{ $l['url'] }}" title="{{ $l['text'] }}" target="_blank">
						<span class="icon-span {{ $l['class'] }}-span">
							<img src="@asset('images/' . $l['class'] . '.svg')" loading="lazy" alt="{{ $l['class'] }} icon">
						</span>
						@if ($l['class'] === 'link-share')
								<span class="link-btn-copied">Link copied!</span>
							@endif
							
						</a>
					</li>
					
				@endforeach				
			</ul>
		@endif
	</div>
</div>