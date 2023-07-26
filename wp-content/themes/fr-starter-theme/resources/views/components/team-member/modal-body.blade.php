<div class="member-info">
	<div class="featured-image {{ $is_empty_featured_image ? 'default':'' }}">
		<img src="{{ $featured_image['url'] }}" loading="lazy" alt="Featured">
	</div>
	<div class="right-content">
        <div class="wysiwyg-content">
			<h5 class="title">
                {!! $title !!}
            </h5>
			<h6 class="role sm">
                {{ $role }}
			</h6>
			{!! $short_bio !!}
		</div>
	</div>
</div>