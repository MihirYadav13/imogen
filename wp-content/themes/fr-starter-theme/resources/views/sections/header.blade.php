<header class="banner fr-header ">
	<nav class="navbar navbar-expand-lg">
		<div class="container">
			<a class="brand" href="{{ home_url('/') }}">
				@if ($logo && is_array($logo))
					<img class="header-logo" src="{{ $logo['url'] }}" alt="{{ $logo['alt'] }}" loading="lazy">
				@else
					{!! $siteName !!}
				@endif
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#headerMenuContent" aria-controls="headerMenuContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon">
					<img class="menu-icon" src="@asset('images/menu.svg')"/>
					<img class="close-icon" src="@asset('images/close.svg')"/>
				</span>
			</button>
			<div class="collapse navbar-collapse" id="headerMenuContent">
				@if (has_nav_menu('primary_navigation'))
					{!! wp_nav_menu($primaryNavigation) !!}
				@endif
				<div class="right-nav-container">
					@forelse($right_cta as $cta)
						<x-cta-button :label="$cta['label']" :type="$cta['cta_type']" :post-id="$cta['post_id']" :style="$cta['style']" :external-url="$cta['externa_url']" :new-tab="$cta['new_tab']" />
					@empty
					@endforelse
				</div>
			</div>
		</div>
	</nav>
</header>

