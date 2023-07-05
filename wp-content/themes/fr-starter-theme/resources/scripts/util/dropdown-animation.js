

(function ($) {
	$.fn.dropdownAnimate = function () {
		return this.each((i, el) => {
			const $self = $(el);
			
            // Add slideDown animation to Bootstrap dropdown when expanding.
            $self.on('show.bs.dropdown', function(event) {
                $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
            });

            // Add slideUp animation to Bootstrap dropdown when collapsing.
            $self.on('hide.bs.dropdown', function(event) {
                $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
            });
        });
	}

	$(() => {
		$('.dropdown').dropdownAnimate();
	});
})($);