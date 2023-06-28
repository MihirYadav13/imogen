<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ApiThemeSettings extends Partial
{
    /**
     * The partial field group.
     *
     * @return \StoutLogic\AcfBuilder\FieldsBuilder
     */
    public function fields()
    {
        $apiThemeSettings = new FieldsBuilder('api_theme_settings');

        $apiThemeSettings
            ->addText('api_key')
            ->addText('api_endpoint_url');

        return $apiThemeSettings;
    }
}
