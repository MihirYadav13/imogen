(function ($) {
	$.fn.frShareButton = function () {
        return this.each((i, el) => {
			const $self = $(el);
            const $linkIcon = $self.find('.link-share');
            $linkIcon.on('click', (e) => {
                console.log('in'+$linkIcon.attr('href'));
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
	