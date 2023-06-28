<div class="module weave-slider-module {{ $block->classes }}" @if(isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif>
	<div class="container-fluid weave-aspect-ratio-container" style="padding-bottom:{{ $container_height }}%;">
		<div class="weave-slider-container">
			<div class="weave-slider-inner">
				<div class="left-side-container">
					<div class="side-inner">
						@if ($right_side['label'])
							<span class="tag right">{{ $right_side['label'] }}</span>
						@endif
						@if ($right_side['image'] && is_array($right_side['image']))
							@include('components.responsive-acf-image', ['image' => $right_side['image']])
						@endif
					</div>
				</div>
				<div class="right-side-container" style="width:50%;">
					<div class="side-inner">
						@if ($left_side['label'])
							<span class="tag left">{{ $left_side['label'] }}</span>
						@endif
						@if ($left_side['image'] && is_array($left_side['image']))
							@include('components.responsive-acf-image', ['image' => $left_side['image']])
						@endif
					</div>
				</div>
				<input type="range" min="0" max="100" value="50" class="slider-input" name="slider" id="{{ $block->block->id }}-slider">
				<div class="slider-button badge" style="left:calc(50% - 12.5px);"></div>
			</div>
		</div>
	</div>
</div>
