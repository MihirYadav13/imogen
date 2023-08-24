<div class="inner-content card-{{ $post_type }}">
	<div class="featured-image {{ $is_empty_featured_image ? 'default':'' }}">
		<img src="{{ $featured_image['url'] }}" loading="lazy" alt="Featured">
	</div>
	<div class="right-content">
		<div class="wysiwyg-content">
			<div class="section">
				@if(in_array($post_type, ['camp', 'after-school-program']))
				<h4 class="title">
					{!! $title !!}
				</h4>
				@else
				<h5 class="title">
					{!! $title !!}
				</h5>
				@endif
				@if($post_type === 'camp')
				<h6 class="theme-color">
					{{ $subheading }}
				</h6>	
				@endif
				@if($post_type === 'after-school-program')
				<h6 class="theme-color">
					{{ $location }}
				</h6>	
				@endif
			
				@if($post_type === 'team-member')
				<h6 class="role sm theme-color">
					{{ $role }}
				</h6>
				@endif
			</div>

			<div class="section">
				@if($post_type === 'team-member')
				<div class="short-bio">
				{!! $short_bio !!}
				</div>
				@endif
				@if(in_array($post_type, ['camp','after-school-program']))
					<p class="description section">{{ $description }}</p>
					<div class="info-container">
						@forelse($camp_info as $info)
							@if($info['value'] !== '')
								<div class="info-row">
									<label class="sm">{{ $info['label'] }}:</label>
									<p class="value sm">{!! $info['value'] !!}</p>
								</div>
							@endif
						@empty
						@endforelse
					</div>
				@endif
			</div>
			@if(!empty($registration_link) || !empty($contact_us_page))
                <div class="content-footer">
                    @if(!empty($registration_link))
                    <x-cta-button label="Register" type="external_url" :external-url="$registration_link" style="primary" :new-tab="true"/>
                    @endif
                    @if($contact_us_page)
						<x-cta-button label="Contact Us" type="external_url" style="secondary" :external-url="$contact_us_page" :new-tab="false" />
					@endif
                </div>
            @endif
		</div>
	</div>
</div>