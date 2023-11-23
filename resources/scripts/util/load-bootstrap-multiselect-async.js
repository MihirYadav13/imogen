(function($) {
	$(() => {
		let libraryLoaded = false;
		let libraryIsLoading = false;

		const fetchLib = (callback) => {
			if(!libraryLoaded){
				if(!libraryIsLoading){
					libraryIsLoading = true;
					window.fetchInject([
						'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.min.js',
					]).then(() => {
						libraryLoaded = true;
						if(callback) callback();
					});    
				}
			}else{
				if(callback) callback();
			}
		}

		$(window).on('fr:load-bsmultiselectjs', (ev) => {
			fetchLib(() => {
				$(window).trigger('fr:bsmultiselectjs-loaded');
			});
		});
	});
})(jQuery);