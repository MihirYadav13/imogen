(function ($) {
	const initializeGrid = ($self) => {
		let _ = {
			ajaxConfig: JSON.parse(($self.attr('ajax-config') ? $self.attr('ajax-config') : '{}')),
			cardModalConfig: JSON.parse(($self.attr('card-modal-config') ? $self.attr('card-modal-config') : '{}')),
			connectedFilters: JSON.parse(($self.attr('connected-filters') ? $self.attr('connected-filters') : '[]')),
            ajaxContainer: $self.find('.ajax-container'),
            resultContainer: $self.find('.filters-result-container'),
            cardsContainer: $self.find('.cards-container'),
            loadMoreBtn: $self.find('.load-btn-container a'),
			cardModal: $self.find('.card-modal').length ? $self.find('.card-modal').attr('id') :false,
            ajaxRunning: false,
            hasMore: true
		}

		// On click load more button
		_.loadMoreBtn.on('click', () => {
			loadNextPage($self, _);
		});

		connectFrontendFilters($self, _);
		initializeCardModal($self, _);
	}

	const connectFrontendFilters = ($self, _) => {
		if(!_.connectedFilters || _.connectedFilters.length === 0){
			return;
		}		

		_.connectedFilters.forEach( filter => {
			// On filter changed trigger
			$(`#${filter}`).on('fr:filters-changed', (event, formData) => {
				
				_.ajaxConfig = {
					..._.ajaxConfig,
					...formData
				}

				loadFirstPage($self, _);

			});

			// On filter reset trigger
			$(`#${filter}`).on('fr:filters-reset', (event, formElements) => {
				
				formElements.forEach(ele => {
					if(_.ajaxConfig.hasOwnProperty(ele)){
						delete _.ajaxConfig[ele];
					}
				});

				loadFirstPage($self, _);
			});
		});
	}


	const initializeCardModal = ($self, _) => {
		if(!_.cardModal) return;

		let $modal = $(`#${_.cardModal}`);

		$self.on('click', '.card-type-team-member, .card-type-after-school-program .card-footer .cta-button, .card-type-camp .card-footer .cta-button',  (e) => {
			e.preventDefault();
			$modal.find('.modal-body .card-content').html('');
			$modal.modal('show');
			$modal.attr('fr-status', 'loading');
			let postId = $(e.target).closest('.fr-card').attr('post-id');
			
			// // Get member info
			$.ajax({
				url: _.cardModalConfig.url,
				data: {action: _.cardModalConfig.action, postId}
			}).done(function(resData) {
				$modal.find('.modal-body .card-content').html(resData.data.modalBody);
				$modal.attr('fr-status', 'success');

				// If content not visible scroll to content
				if( ['xs', 'sm', 'md'].includes(window.currentBreakpoint()) && $(window).outerHeight() < ($modal.find('.featured-image ').outerHeight() + 300)){
					$modal.animate({
						scrollTop: ($modal.find('.featured-image ').outerHeight() - 50)
					}, 500);
				}

			}).fail(err => {
				$modal.attr('fr-status', 'fail');
				console.log('Failed: ' + JSON.stringify(err));
			});	
		});	
	}


	// Function for get html data for first page
	const loadFirstPage = ($self, _) => {
		if (_.ajaxRunning) return;
		
		//Start
		_.ajaxRunning = true;
		$self.attr('fr-status', 'loading-result');

		_.ajaxConfig.page = 1;

		// Get data using ajax
		$.ajax({
			url: _.ajaxConfig.url,
			action: _.ajaxConfig.action,
			data: _.ajaxConfig,
		}).always((jqXHR, status) => {
			_.ajaxRunning = false;
		}).done(function(resData) {
			_.cardsContainer.find('.fr-card').remove();
			$.each(resData.data.posts, (i, card) => { 
				_.cardsContainer.append($(card));
			});
			setPagination(resData.data, $self, _);
		}).fail(err => {
			$self.attr('fr-status', '');
			console.log('Failed: ' + JSON.stringify(err));
		});
	}

	// Function for get html data for next page
	const loadNextPage = ($self, _) => {
		if (_.ajaxRunning) return;
		if (!_.hasMore) return;
		
		//Start
		_.ajaxRunning = true;
		$self.attr('fr-status', 'ajax-running');

		_.ajaxConfig.page += 1;

		// Get data using ajax
		$.ajax({
			url: _.ajaxConfig.url,
			action: _.ajaxConfig.action,
			data: _.ajaxConfig,
		}).always((jqXHR, status) => {
			_.ajaxRunning = false;
		}).done(function(resData) {
			// Attach cards
			$.each(resData.data.posts, (i, card) => { 
				_.cardsContainer.append($(card));
			});
			setPagination(resData.data, $self, _);
		}).fail(err => {
			$self.attr('fr-status', '');
			console.log('Failed: ' + JSON.stringify(err));
		});
	}

	// Function for set pagination
	const setPagination = (resData, $self, _) => {
		_.hasMore = resData.hasMore;
		// If hasMore
		if (_.hasMore) {
			_.resultContainer.addClass('has-more-pages');
		}
		else {
			_.resultContainer.removeClass('has-more-pages');
		}
		
		// Add fr status
		if(resData.posts.length === 0 && _.ajaxConfig.page === 1){
			$self.attr('fr-status', 'no-results-found');
		}
		else if(!_.hasMore) {
			$self.attr('fr-status', 'no-more-results');
		}
		else {
			$self.attr('fr-status', '');
		}
	}

	$.fn.cardGrid = function () {
		return this.each((i, el) => {
			const $self = $(el);
			const $gridContainer = $self;

			initializeGrid($gridContainer);
		});
	}

	$(() => {
		$('.card-grid-container').cardGrid();
	});
})(jQuery);