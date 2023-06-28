<div class="fr-hero hero {{ $block->classes }}">
	@include('components.responsive-acf-image', ['image' => $background_image, 'class' => 'hero-bg-image desktop'])
	@include('components.responsive-acf-image', ['image' => $background_image_mobile, 'class' => 'hero-bg-image mobile'])
	<div class="container">
		<div class="row {{ $content_box_background_color ?: 'dark-blue' }}-container">
			<div class="col content-col wysiwyg-content col-pos-{{ $content_box_position }}">
				{!! $content !!}
			</div>
		</div>
	</div>
</div>
