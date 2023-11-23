<div class="social-wrapper">
	@forelse ($social_links as $l)
		<a class="alt-btn" href="{{ $l['url']?: '#' }}" target="_blank" title="{{ $l['type'] ? 'Follow us on ' . $l['type']['label'] : '' }}" aria-label="{{ $l['type'] ? 'Follow us on ' . $l['type']['label'] : '' }}">
			@if ($l['type'])
				<img src="{{ asset('images/'.$l['type']['value']).'-tr.svg' }}" alt="{{ $l['type'] ? 'Follow us on ' . $l['type']['label'] : '' }}" loading="lazy">
			@endif
		</a>
	@empty
	@endforelse
</div>