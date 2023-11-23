(function ($) {
	$.fn.article = function () {
		const getTruncationLineConfig = ($self, $el) => {
			let result = 2;

			if($el.hasClass('card-title')){
				result = 2;
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
				$element.parent().find('.more-less').hide();

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
					lines: parseInt($el.attr('fr-truncate-lines') || getTruncationLineConfig($self, $el)),
					tooltip: $el.attr('data-title')
				})
			});

			setUpTruncateElements(truncatableElements);
		}
		const initMoreLess =($self) =>{			
			$self.on('click', '.more-less', function(){
				var moreLessButton = $(this).parents('.full-content').find(".hide-content").is(':visible') ? 'Read More' : 'Read Less';
				$(this).text(moreLessButton);
				$(this).parent('.full-content').find(".hide-content").toggle();
				$(this).parent('.full-content').find(".exerpt").toggle();
				});
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
			initMoreLess($self);
        });
	}
	
	$(() => {
		$('.article-list-module').article();
	});
	
})($);