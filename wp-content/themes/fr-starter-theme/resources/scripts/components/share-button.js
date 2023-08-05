(function ($) {
	$.fn.frShareButton = function () {
        return this.each((i, el) => {
			const $self = $(el);
            const $linkIcon = $self.find('.social-sharing-links .share-btn.link-share');
            $linkIcon.on('click', (e) => {
                e.preventDefault();
                if(window.navigator){
                    window.navigator.clipboard.writeText($linkIcon.attr('href'));

                    $linkIcon.find('.link-btn-copied').addClass('is--animated');

                    setTimeout(() => {
                        $linkIcon.find('.link-btn-copied').removeClass('is--animated')
                    }, 1000);
                }
            })
		});
	}
    $(() => {
		$('.fr-share-button').frShareButton();
	});
})($);
	