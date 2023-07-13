<div class="fr-card card-type-{{ $post_type }}">
	<div class="card-inner">
        @if(!empty($card_data['featured_image']))
			<div class="featured-image">
				<img src="{{ $card_data['featured_image']['url'] }}" loading="lazy" alt="Featured">
			</div>
		@endif
        <div class="card-content">
            <div class="wysiwyg-content">
                <div class="card-header">
                    <a href="{{ $card_data['permalink'] }}" class="card-link">
                        <h6 class="card-title" fr-truncate-lines="3" title="{{ $card_data['title'] }}">
                            {!! $card_data['title'] !!}
                        </h6>
                    </a>
                </div>
                <div class="card-body">
                    @if($post_type === 'after-school-program')
                        <p class="location sm">
                            {{ $card_data['location'] }}
                            @if($card_data['school_website'])
                                <a class="website sm" href="{{ $card_data['school_website']['url'] }}" alt="Website" target="{{ $card_data['school_website']['target'] }}">{{ $card_data['school_website']['title'] }}</a>
                            @endif
                        </p>
                    @endif
                    @if($post_type === 'student-success')
                        <p class="excerpt sm">{!! $card_data['excerpt'] !!}</p>
                    @endif
                </div>
                @if(!empty($card_data['registration_link']))
                    <div class="card-footer">
                        <x-cta-button label="{!! $post_type === 'after-school-program' ? 'Schedule & Registration' : 'Register' !!}" type="external" style="primary"/>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>