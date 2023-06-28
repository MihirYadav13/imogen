<?php

namespace App\Options;

use Log1x\AcfComposer\Options as Field;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\HeaderThemeSettings;
use App\Fields\Partials\FooterThemeSettings;
use App\Fields\Partials\ApiThemeSettings;

class ThemeSettings extends Field
{
    /**
     * The option page menu name.
     *
     * @var string
     */
    public $name = 'Theme Settings';

    /**
     * The option page document title.
     *
     * @var string
     */
    public $title = 'Theme Settings | Options';

    /**
     * The option page field group.
     *
     * @return array
     */
    public function fields()
    {
        $themeSettings = new FieldsBuilder('theme_settings');

        $themeSettings
            ->setLocation('options_page', '==', 'theme-settings')
            ->addTab('Header')
                ->addFields($this->get(HeaderThemeSettings::class))
            ->addTab('Footer')
                ->addFields($this->get(FooterThemeSettings::class))
            ->addTab('API Settings')
                ->addFields($this->get(ApiThemeSettings::class));

        return $themeSettings->build();
    }
}
