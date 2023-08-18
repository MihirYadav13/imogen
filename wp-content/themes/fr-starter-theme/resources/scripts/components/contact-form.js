(function($) {

    $.fn.ContactFormPreventMultiSubmit = function() {
        this.each(() => {
            const $self = $(this);
            let disableSubmit = false;
            $self.find('*[type="submit"]').on('click', function() {
                if (disableSubmit == true) {
                    return false;
                }
                disableSubmit = true;
                return true;
            });

            let wpcf7Elm = document.querySelector( '.wpcf7' );
            wpcf7Elm.addEventListener( 'wpcf7submit', function( event ) {
                disableSubmit = false;
            }, false );
        });
    }

    $(() => {
		//$('.wpcf7').ContactFormPreventMultiSubmit();
	});
    
})(jQuery);