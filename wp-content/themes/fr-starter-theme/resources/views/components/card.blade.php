<div class="fr-card card-type-{{ $post_type }}" post-id="{{ $card_data['post_id'] }}">
	<div class="card-inner">
        @if(!empty($card_data['featured_image']))
			<div class="featured-image {{ $card_data['is_empty_featured_image'] ? 'default':'' }}">
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
                    @if($post_type === 'camp')
                        <div class="info-container">
                            @forelse($card_data['camp_info'] as $info)
                                <label class="sm">{{ $info['label'] }}:</label>
                                <p class="value sm">{{ $info['value'] }}</p>
                            @empty
                            @endforelse
                        </div>
                    @endif
                    @if($post_type === 'student-success')
                        <p class="excerpt sm">{!! $card_data['excerpt'] !!}</p>
                    @endif
                    @if($post_type === 'team-member')
                        <p class="role sm">
                            {{ $card_data['role'] }}
                        </p>
                    @endif
                </div>
                @if(!empty($card_data['registration_link']) || !empty($card_data['action_cta']))
                    <div class="card-footer">
                        @if(!empty($card_data['registration_link']))
                        <x-cta-button label="{!! $post_type === 'after-school-program' ? 'Schedule & Registration' : 'Register' !!}" type="external_url" style="primary"/>
                        @endif
                        @if(!empty($card_data['action_cta']))
                        <x-cta-button :label="$card_data['action_cta']['title']?:'Learn More'" :external-url="$card_data['action_cta']['url']" type="external_url" :style="$card_data['action_cta']['style']?:'primary'"/>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>