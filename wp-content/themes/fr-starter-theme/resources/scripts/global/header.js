import { Collapse } from 'bootstrap';

(function ($) {

    const updateDropdownTrigger = ($navLinks, breakpoint) => {
        if(['xs', 'sm', 'md', 'lg'].includes(breakpoint)){
            $navLinks.removeAttr("data-bs-hover");
            $navLinks.attr("data-bs-toggle", "dropdown");
        }else{
            $navLinks.removeAttr("data-bs-toggle");
            $navLinks.attr("data-bs-hover", "dropdown");
        }
    }


    const updateTopSpacing = ($self) => {
        let headerBottom = $($self).position().top + $($self).outerHeight(true);

        if(!$('body').hasClass('home')){
            $('body').css('padding-top', `${headerBottom}px`);
        }
    }

    const resetMenuItems = ($items) => {
        $.each($items, (i, el) => { 
            $(el).removeClass('show');
            $(el).find('.dropdown-menu').removeClass('show');
        });
    }

    const showDropdown = ($el, closeSiblings = false) => {
        $el.addClass('show');
        $el.find('.nav-link').addClass('show');
        $el.find('.dropdown-menu').addClass('show');

        if(closeSiblings){
            const $siblings = $el.parent().find(".menu-item.dropdown, .menu-item.fr-has-mm").not($el);

            $siblings.removeClass('show');
            $.each($siblings, (i, el) => { 
                //$el.find('.nav-link').removeClass('show');
                $(el).find('.dropdown-menu').removeClass('show');
            });
        }
    }

    const hideDropdown = ($el) => {
        $el.removeClass('show');
        $el.find('.nav-link').removeClass('show');
        $el.find('.dropdown-menu').removeClass('show');
    }

	$.fn.frHeader = function () {
		return this.each((i, el) => {
			const $self = $(el);
            const $menuContent = $('#headerMenuContent');
            const collapse = new Collapse($menuContent[0], {
                toggle: false
            });
            $self.currentBreakpoint = window.currentBreakpoint();

            $self.on('fr:trigger-close-menu', (ev) => {
                collapse.hide();
            });

            $self.on('fr:scroll-down', (ev) => {
                collapse.hide();
            });

            $menuContent.on('hidden.bs.collapse', (ev) => {
                $(window).trigger('fr:reset-menu-items');
                $self.removeClass('is--opened is--opening is--closing');
            });

            $menuContent.on('hide.bs.collapse', (ev) => {
                $self.removeClass('is--opened').addClass('is--closing');
            });
            
            $menuContent.on('shown.bs.collapse', (ev) => {
                $self.removeClass('is--opening').addClass('is--opened');
            });
            
            $menuContent.on('show.bs.collapse', (ev) => {
                $self.addClass('is--opening');
            });

            $(window).on('resize', () => {
                const newBreakpoint = window.currentBreakpoint();

                if(newBreakpoint !== $self.currentBreakpoint){
                    $self.currentBreakpoint = newBreakpoint;

                    updateDropdownTrigger($menuContent.find(".nav-link.dropdown-toggle"), $self.currentBreakpoint);

                    if( !['xs', 'sm', 'md', 'lg'].includes($self.currentBreakpoint) ){
                        $('.dropdown-menu').css('display','');
                        $self.trigger('fr:trigger-close-menu');
                        $self.removeClass('is--opened is--opening is--closing');
                    }
                }

                //updateTopSpacing($self);
            });

            $menuContent.find(".menu-item.dropdown").on({
                mouseenter: function(){
                    const $el = $(this);
                    if(!['xs', 'sm', 'md', 'lg'].includes($self.currentBreakpoint)){
                        showDropdown($el, true);
                    }
                },
                mouseleave: function(){
                    const $el = $(this);
                    if(!['xs', 'sm', 'md', 'lg'].includes($self.currentBreakpoint)){
                        setTimeout(() => {
                            hideDropdown($el);
                        }, 300);
                    }
                }
            });

            $(window).on('fr:reset-menu-items', () => {
                resetMenuItems($menuContent.find(".menu-item.dropdown"));
            });

            var scrolled = 0;
            const minScroll = 5;
            $(window).on('scroll', () => { 

                let headerHeight = $($self).outerHeight(true);
                let toolBarHeight = $('#wpadminbar').length ? $('#wpadminbar').outerHeight(true) : 0;

                // Minimum scroll check
                if(Math.abs(scrolled - window.scrollY) < minScroll) {
                    return;
                }

                // Check if scroll down 10px below element
                if (window.scrollY > $self.height() + 10) { 
                    $self.addClass('scrolled');

                    // Check scroll sirection
                    if(scrolled < window.scrollY) {
                        $self.addClass('scroll-down');
                        $self.trigger('fr:scroll-down');
                        //$self.css('top', `-${headerHeight + toolBarHeight}px`);
                    } else {
                        $self.removeClass('scroll-down');
                        //$self.css('top', `${toolBarHeight}px`);
                    }
                } else { 
                    $self.removeClass('scrolled');
                    $self.removeClass('scroll-down');
                    //$self.css('top', `${toolBarHeight}px`);
                }

                scrolled = window.scrollY;
            });

            //on page load
            updateDropdownTrigger($menuContent.find(".nav-link.dropdown-toggle"), $self.currentBreakpoint);
            //updateTopSpacing($self);
		});
	}

	$(() => {
		$('header.fr-header').frHeader();
	});
})($);