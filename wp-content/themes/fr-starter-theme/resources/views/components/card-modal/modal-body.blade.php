<div class="inner-content card-{{ $post_type }}">
	<div class="featured-image {{ $is_empty_featured_image ? 'default':'' }}">
		<img src="{{ $featured_image['url'] }}" loading="lazy" alt="Featured">
	</div>
	<div class="right-content">
		<div class="wysiwyg-content">
			<h5 class="title">
				{!! $title !!}
			</h5>
			@if($post_type === 'team-member')
			<h6 class="role sm">
				{{ $role }}
			</h6>
			{!! $short_bio !!}
			@endif
			@if(in_array($post_type, ['camp']))
                <div class="info-container">
                    @forelse($camp_info as $info)
                        <label class="sm">{{ $info['label'] }}:</label>
                        <p class="value sm">{{ $info['value'] }}</p>
                    @empty
                    @endforelse
                </div>
            @endif
			@if(!empty($registration_link) || !empty($action_cta))
                <div class="content-footer">
                    @if(!empty($registration_link))
                    <x-cta-button label="Register" type="external_url" style="primary"/>
                    @endif
                    @if(!empty($action_cta))
                    <x-cta-button :label="$action_cta['title']?:'Learn More'" :external-url="$action_cta['url']" type="external_url" :style="$action_cta['style']?:'primary'"/>
                    @endif
                </div>
            @endif
		</div>
	</div>
</div>