<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class FooterThemeSettings extends Partial
{
    /**
     * The partial field group.
     *
     * @return \StoutLogic\AcfBuilder\FieldsBuilder
     */
    public function fields()
    {
        $footerThemeSettings = new FieldsBuilder('footer_theme_settings');

        $footerThemeSettings
            ->addMessage('Footer Note', 'Go to Appereance > Menus to customize the footer menu')
            ->addText('gravity_form_shortcode', [
                'label' => 'Gravity Forms: Footer Form Shortcode'
            ]);

        return $footerThemeSettings;
    }
}
