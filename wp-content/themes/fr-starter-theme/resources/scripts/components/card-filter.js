(function ($) {
	const arrayFilters = ['selected_topics', 'related_strategies', 'keyword-tag', 'resource-type'];
	// Function for set pagination
	const filtersChanged = ($filterForm) => {
		let formData = $($filterForm)
			.serializeArray();
			
			console.log('formData',formData);

			/**
			 * Special case for multiple select because what happens is that
			 * when ajaxConfig originally has a value for 'input_1' and we
			 * then change the value to be '' or null, then when we do
			 * {..._.ajaxConfig, ...newConfig} then the old value in _.ajaxConfig
			 * still remains
			 */
			$.each($($filterForm).find('select[multiple]'), (i, el) => { 
				formData.push({
					name: $(el).attr('name'),
					value: $(el).val() 
				});
			});

			formData = formData.reduce(function (json, { name, value }) {
				if(arrayFilters.includes(name)){
					json[name] = json[name]?json[name].concat(value):[value];
				}
				else {
					json[name] = value;
				}
				return json;
			}, {});

			triggerUpdateUrl($filterForm);
			
		$($filterForm).trigger('fr:filters-changed', [formData]);
	}

	// Function for reset filters
	const resetFilters = ($filterForm) => {
		$filterForm.reset();
		$($filterForm).find('select.bs-multiselect').multiselect('deselectAll', false);

		let formElements = JSON.parse(($($filterForm).attr('form-elements') ? $($filterForm).attr('form-elements') : '[]'));
		triggerUpdateUrl($filterForm);
		$($filterForm).trigger('fr:filters-reset', [formElements]);
	}

	// Function to trigger update url
	const triggerUpdateUrl = ($filterForm) => {
		let paramJson = $($filterForm)
				.serializeArray()
				.reduce(function (json, { name, value }) {
					if(arrayFilters.includes(name)){
						json[name] = json[name]?json[name].concat(value):[value];
					}
					else if(json[name]){
						json[name] = value;
					}
					return json;
				}, {});

		let urlParams = Object.keys(paramJson).map(param => `${param}=${paramJson[param]}`).join('&');

		$(window).trigger('fr:update-url-params', [urlParams]);
	}

	$.fn.cardFilter = function () {
		return this.each((i, el) => {
			const $self = $(el);
			const $filterForms = $self.find('form');

			$filterForms.each((index, form) => {
				// On multiselect changed
				$(form).find('select').on('change', () => {
					filtersChanged(form);
				});

				// On sort changed
				$(form).find('.sort-by-filters input[type="radio"]').on('change', () => {
					filtersChanged(form);
				});
				
				// On search form submit
				$(form).on('submit', (e) => {
					e.preventDefault();
					filtersChanged(form);
				});

				// On click of reset filters
				$(form).find('.reset-filters-container a').on('click', () => {
					resetFilters(form);
				});
			});
			
		});
	}

	$(() => {
		$('.card-filter-component').cardFilter();
	});
})(jQuery);