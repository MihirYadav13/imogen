<div class="fr-card card-type-{{ $post_type }}">
	<div class="card-inner {{ $post_type === 'strategy' ? 'light-blue-container' : '' }}">
		<div class="wysiwyg-content">
			@if ($post_type === 'resource')
				<x-resource-type-tag :post="$post" />
			@endif
			@if ($post_type === 'case-study')
				<div class="resource-type-tag">
					<img src="{{ asset('images/case-study-logo.svg') }}" loading="lazy" alt="Magnifying Glass">
					Case Study
				</div>
			@endif
			@if ($post_type === 'strategy')
				@include('partials.cards-topics-tags', ['topics' => $card_data['topics'], 'is_featured' => $card_data['is_featured']])
			@endif
                <a href="{{ $card_data['permalink'] }}" class="card-link">
                    <h3 class="card-title" fr-truncate-lines="3" title="{{ $card_data['title'] }}">
                        {!! $card_data['title'] !!}
                    </h3>
                </a>
			<p class="date">{!! $card_data['date'] !!}</p>
		</div>
    </div>
    <div class="card-footer">
        @if($post_type === 'strategy')
            @include('partials.cards-keyword-tags', ['keyword_tags' => $card_data['keyword_tags']])
        @endif
        @if($post_type === 'resource')
            <a href="{{ $card_data['resource_file_url'] ?: $card_data['permalink'] }}" class="cta-button primary has-icon card-link {{ $card_data['button_class'] }}">
                <b></b> {{ $card_data['button_label'] }}
            </a>
        @endif
        @if($post_type === 'case-study')
            <x-cta-button label="Read More" type="post_id" :post-id="$post" style="terciary"/>
        @endif
		<x-like-button :post="$post" />
	</div>
</div>