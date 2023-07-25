<?php
if (!class_exists('WysiwygCustomFormats')) :

    class WysiwygCustomFormats
    {

        public function __construct()
        {

            add_filter('mce_buttons_2', [$this, 'AddFormtDropdownToWysisyg']);

            // Attach callback to 'tiny_mce_before_init' 
            add_filter('tiny_mce_before_init', [$this, 'my_custom_styles']);
        }

        public function AddFormtDropdownToWysisyg($buttons)
        {
            array_unshift($buttons, 'styleselect');
            return $buttons;
        }

        //add custom styles to the WordPress editor
        public function my_custom_styles($init_array)
        {

            $style_formats = array(
                // These are the custom styles
                array(
                    'title' => 'Subheading',
                    'block' => 'h5',
                    'classes' => 'sub'
                )
            );
            // Insert the array, JSON ENCODED, into 'style_formats'
            $init_array['style_formats'] = json_encode($style_formats);

            return $init_array;
        }
    }
    /**
     * Initialize class
     */
    global $WysiwygCustomFormats;
    $WysiwygCustomFormats = new \WysiwygCustomFormats();
endif;
