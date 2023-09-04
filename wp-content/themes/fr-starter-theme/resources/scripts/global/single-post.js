import { Collapse } from 'bootstrap';

(function ($) {
	$.fn.frpostBackgroundShift = function () {
		return this.each((i, el) => {
			const $self = $(el);
            const $backgroundGre = $self.find('.fr-content-row').css('background');
            $self.find('.fr-content-row').css('background','none');
            $self.css('background', $backgroundGre);
		});
	}
	$(() => {
		$('body.single-post').frpostBackgroundShift();
	});
})($);