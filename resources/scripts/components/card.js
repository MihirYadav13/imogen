(function ($) {
	$.fn.frCard = function () {

		/**
		 * If the element does not have a value on the fr-truncate-lines property
		 * let's use this to configure it based off designs. THIS SHOULD BE DEPRECATED
		 * AT SOME POINT, KIND OF DIFFICULT TO MAINTAIN
		 * 
		 * @param {*} $self 
		 * @param {*} $el 
		 * @returns 
		 */
		const getTruncationLineConfig = ($self, $el) => {
			let result = 3;
			if($el.parents('.cards-container').hasClass('columns-2') && $(window).width() >= 960){
				if($el.hasClass('card-title')){
					result = 3;
				}
				else{
					result = 6;
				}
			}
			else{
				if($el.hasClass('card-title')){
					result = 2;
				}
				else{
					result = 4;
				}
			}
			
			return result;
		}

		const truncateText = ($element, lines) => {
			//Set original text first
			if($element.frOriginalText){
				$element.text($element.frOriginalText);
			}
			
			const elHeight = $element.height();
			const lineHeight = parseFloat($element.css('line-height'));
		
			if(elHeight / lineHeight > lines){

				$(window).trigger('fr:truncate-text', [$element, Math.ceil(lineHeight * lines), false, function(){
					//remove the class that avoids flash of styles
					$element.parent().removeClass('not--truncated');
				}]);
			}else{
				$element.parent().removeClass('not--truncated');
			}
		}

		const setUpTruncateElements = (elements) => {
			$.each(elements, (i, el) =>  { 
				const $el = el.$el;
				const lines = el.lines;
				const tooltip = el.tooltip;
				let resizeDebounce = false;

				//save original value 
				$el.frOriginalText = $el.text();

				//do truncation
				truncateText($el, lines);

				//add tooltip if needed
				if(tooltip && tooltip.length){
					$el.tooltip({ 
						placement: 'auto',
						title: () => {
							return tooltip;
						}
					});
				}

				//add event on resize
				$(window).on('resize', () => {
					clearTimeout(resizeDebounce);
					resizeDebounce = setTimeout(() => {
						truncateText($el, lines);
					}, 400);
				});
			});
		}

		const initializeTruncation = ($self) => {
			const truncatableElements = [];
			$.each($self.find('[fr-truncate-lines]'), (i, el) => { 
				const $el = $(el);
				
				truncatableElements.push({
					$el: $el,
					lines: parseInt(getTruncationLineConfig($self, $el) || $el.attr('fr-truncate-lines')),
					tooltip: $el.attr('data-title')
				})
			});

			setUpTruncateElements(truncatableElements);
		}

		return this.each((i, el) => {
			const $self = $(el);

			if(!window.frFontsLoaded){
				$(window).on('fr:fonts-loaded', () => {
					initializeTruncation($self);
				});
			}else{
				initializeTruncation($self);
			}
        });
	}

	$.initialize('.fr-card', function() {
		$(this).frCard();
	});
})(jQuery);