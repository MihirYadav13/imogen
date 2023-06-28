<section class="fr-hero home-hero {{ $block->classes }} {{ $enable_typewritter_effect ? 'has-typewriter-effect' : '' }}"  @if(isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
	@include('components.responsive-acf-image', ['image' => $background_image, 'class' => 'home-hero-bg-image hide-on-mobile'])
	@include('components.responsive-acf-image', ['image' => $background_image_mobile, 'class' => 'home-hero-bg-image hide-on-desktop'])
	<div class="container">
		<div class="row row-top">
			<div class="col col-lg-7 wysiwyg-content">
				<h1 class="max-height-title">
					<strong>{{ $longest_hero_text }}</strong>
					<div class="visible-title">
						<h1>
							{{ $hero_text }}
							<span class="typewriter-effect-container"></span>
							@foreach ($typewriter_phrases as $i => $p)
								<span class="typewriter" data-index="{{$i}}">{{ $p['phrase'] }}</span>
							@endforeach
						</h1>
					</div>
				</h1>
				@if ($hero_text_cta)
						{!! $hero_text_cta !!}
				@endif
			</div>
		</div>
		@if ($enable_text_box)
			<div class="row justify-content-md-end justify-content-center row-bottom">
				<div class="col-lg-5 glass-blue text-box dark-blue-container">
					<div class="wysiwyg-content">
						{!! $text_box_content !!}
					</div>
				</div>
			</div>
		@endif
	</div>
</section>
