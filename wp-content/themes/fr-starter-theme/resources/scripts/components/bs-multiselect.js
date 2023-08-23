(function ($) {
    require('selectric');

    $(() => {
        const selector = '.bs-multiselect select, select.bs-multiselect';
        const defaultConfig = {
            templates: {
                button: '<button type="button" class="multiselect dropdown-toggle btn" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>',
                popupContainer: '<div class="multiselect-container dropdown-menu"></div>',
            },
            dropUp: false,
            maxHeight: 200
        };

        //Hack to go around the issue where Gravity Forms resets custom dropdowns on ajax validation
        $(window).on('fr:initialize-multiselect', () => {
            
            const $elems = $(selector);
            if($elems.length){
                $(window).on('fr:bsmultiselectjs-loaded', () => {
                    $.each($elems, (i, el) => {
                        const configObj = JSON.parse($(el).attr('multiselect-config') || '{}');
                        $(el).multiselect({
                            ...defaultConfig, 
                            ...configObj,
                            ...{
                                onChange: function(option, checked, select) {
                                    $(el).trigger('fr:multiselect-changed');
                                }
                            }
                        });
                    });
                    
                });
                //$(window).trigger('fr:load-bsmultiselectjs');

                $elems.selectric({
                    forceRenderBelow: true,
                    multiple: {
                        separator: ', ',       // Type: String.             Description: Items separator.
                        keepMenuOpen: true,    // Type: Boolean.            Description: Close after an item is selected.
                        maxLabelEntries: false // Type: Boolean or Integer. Description: Max selected items do show.
                    }
                }).selectric("refresh");

                console.log('I am here');
            }
        });

        $(() => {
            $(window).trigger('fr:initialize-multiselect');
        });
    });
}( jQuery ));