<div class="fr-card card-type-{{ $post_type }}" post-id="{{ $card_data['post_id'] }}">
    <div class="card-inner">
        @if (!empty($card_data['featured_image']))
            <div class="featured-image {{ $card_data['is_empty_featured_image'] ? 'default' : '' }}">
                <img src="{{ $card_data['featured_image']['url'] }}" loading="lazy" alt="Featured">
            </div>
        @endif
        <div class="card-content">
            <div class="wysiwyg-content">
                <div class="card-header">
                    <a href="{{ $card_data['permalink'] }}" class="card-link">
                        <h5 class="card-title" fr-truncate-lines="3" title="{{ $card_data['title'] }}">
                            {!! $card_data['title'] !!}
                        </h5>
                    </a>
                </div>
                <div class="card-body">
                    @if ($post_type === 'after-school-program' || $post_type === 'childhood-education')
                        <p class="location sm">
                            {{ $card_data['location'] }}
                            @if (!empty($card_data['school_website']))
                                <a class="website sm" href="{{ $card_data['school_website']['url'] }}" alt="Website"
                                    target="{{ $card_data['school_website']['target'] }}">{{ $card_data['school_website']['title'] }}</a>
                            @endif
                        </p>
                    @endif
                    @if (in_array($post_type, ['camp', 'post']))
                        <p class="excerpt sm" fr-truncate-lines="4" title="{!! $card_data['title'] !!}">
                            {!! $card_data['description'] !!}</p>
                    @endif
                    @if ($post_type === 'team-member')
                        <p class="role sm">
                            {{ $card_data['role'] }}
                        </p>
                    @endif
                    {{-- @if ($post_type === 'childhood-education')
                        <p class="location sm">
                            {{ $card_data['location'] }}
                        </p>
                    @endif --}}
                </div>
            </div>
            @if (!empty($card_data['registration_link']) || (!empty($card_data['action_cta']) && $post_type === 'post'))
                <div class="card-footer">
                    @if (!empty($card_data['registration_link']))
                        <x-cta-button label="{!! $post_type === 'after-school-program' ? 'Schedule & Registration' : 'Information & Registration' !!}" type="external_url" :external-url="$card_data['registration_link']"
                            style="primary" />
                    @endif
                    @if (!empty($card_data['action_cta']) && $post_type === 'post')
                        <x-cta-button :label="$card_data['action_cta']['title'] ?: 'Learn More'" :external-url="$card_data['action_cta']['url']" type="external_url" :style="$card_data['action_cta']['style'] ?: 'primary'" />
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
{{-- @php
    var_dump($card_data);
@endphp --}}
