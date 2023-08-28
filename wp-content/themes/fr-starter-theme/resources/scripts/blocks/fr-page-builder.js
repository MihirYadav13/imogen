(function ($) {

    $.fn.frBlockContainer = function () {
		return this.each((i, el) => {
			const $self = $(el);
            const $next = $self.next('.fr-content-row');
            
            // Check next container
            if($next.length && ($next.hasClass('section-bg-fade-to-color') || $next.hasClass('section-bg-fade-to-white'))){
                $self.addClass('has-padding-bottom');
            }

		});
	}

	$(() => {
		$('.fr-content-row').frBlockContainer();
	});
})($);