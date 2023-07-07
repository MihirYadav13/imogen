<div class="fr-hero hero {{ $block->classes }}">
	@include('components.responsive-acf-image', ['image' => ['url' => 'https://picsum.photos/seed/picsum/1280/720'], 'class' => 'hero-bg-image desktop'])
	@include('components.responsive-acf-image', ['image' => $background_image_mobile, 'class' => 'hero-bg-image mobile'])
	<div class="content-container">
		<div class="content-background">
			<div class="waveWrapper waveAnimation">
				<div class="waveWrapperInner bgTop">
				<div class="wave waveTop"></div>
				</div>
				<div class="waveWrapperInner bgMiddle">
				<div class="wave waveMiddle"></div>
				</div>
				<div class="waveWrapperInner bgBottom">
				<div class="wave waveBottom"></div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-lg-6 content-col wysiwyg-content">
					{!! $content !!}
				</div>
			</div>
		</div>
	</div>
</div>
