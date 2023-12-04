(function ($) {	
	$.fn.imageCarouselInit = function () {
		const initializeCarousel = ($self) => {
			var main = new Splide($self.find('.q')[0], {
				type: 'fade',
				focus: 'center',
				rewind     : true,
				pagination : false,
				autoplay: false,
			});
			var thumbnails = new Splide( $self.find('.thumbnail-carousel')[0], {
				rewind     : true,
				pagination : false,
				isNavigation: true,
				arrows    : false,
				dragMinThreshold: 10,
				breakpoints: {
					600: {
					  fixedWidth : 60,
					  fixedHeight: 44,
					},
				  },
			});
			main.sync( thumbnails );
			main.mount();
			thumbnails.mount();
		}
		return this.each((i, el) => {
			const $self = $(el);
			const $carouselContainer = $self.find('.image-carousel-container');

			$(window).on("fr:splidejs-loaded", () => {
				initializeCarousel($carouselContainer);
			});
		});
	}
	$(() => {
		$('.image-carousel-module').imageCarouselInit();
	});
})($);