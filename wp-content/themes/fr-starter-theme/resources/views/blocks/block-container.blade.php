<div class="fr-content-row {{ $block->classes }} {{ $background_color }} {{ $show_top_wave }} vert-pad-{{ $vertical_padding }} vert-stack-{{ $vertically_stack_content }}" @if(isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
	@if ($background_image || $background_image_mobile)
		@if ($background_image_size == 'contain')
			@include('components.responsive-acf-image', ['image' => $background_image, 'class' => 'row-bg-image desktop'])
		@else
			@include('components.bg-image-size-auto', ['image' => $background_image, 'class' => 'hide-on-mobile', 'margins' => $background_image_dimensions])
		@endif

		@if ($background_image_mobile_size == 'contain')
			@include('components.responsive-acf-image', ['image' => $background_image_mobile, 'class' => 'row-bg-image mobile'])
		@else
			@include('components.bg-image-size-auto', ['image' => $background_image_mobile, 'class' => 'hide-on-desktop', 'margins' => $background_image_dimensions])
		@endif

		@if ($background_color_overlay)
			<div class="row-bg-overlay" {!! $background_color_overlay !!}></div>
		@endif
	@endif
	<div class="container {{ $content_max_width }} {{ $custom_max_width_class }}" {!! $container_atts !!}>
		@if ($block->preview)
			<div class="fr-empty-slot empty-slot-content-section">
				<i>Edit “Block Container” settings on <a href="javascript:void(0)" fr-open-sidebar-btn>Sidebar Settings <svg style="background: black; margin-left: 5px;" width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill-rule="evenodd" clip-rule="evenodd" fill="white" d="M18 4H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-4 14.5H6c-.3 0-.5-.2-.5-.5V6c0-.3.2-.5.5-.5h8v13zm4.5-.5c0 .3-.2.5-.5.5h-2.5v-13H18c.3 0 .5.2.5.5v12z"></path></svg></a> panel. <br>Click the Appender <span class="appender-icon"></span> below to add Content Blocks, or add “Free Range Columns” to create new row structures.</i>
			</div>
		@endif
		<InnerBlocks allowedBlocks='{{ $allowed_blocks }}' />
	</div>
</div>
