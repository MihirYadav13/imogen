<?php

namespace App\Options;

use Log1x\AcfComposer\Options as Field;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\HeaderThemeSettings;
use App\Fields\Partials\FooterThemeSettings;
use App\Fields\Partials\ApiThemeSettings;
use App\Fields\Partials\ThemeColorFields;
use App\Fields\Partials\GeneralThemeSettings;

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
            ->addTab('General')
                ->addFields($this->get(GeneralThemeSettings::class))
            ->addTab('Header')
                ->addFields($this->get(HeaderThemeSettings::class))
            ->addTab('Footer')
                ->addFields($this->get(FooterThemeSettings::class))
            ->addTab('Stay Connected')
                ->addText('stay_connected_title')
                ->addWysiwyg('stay_connected_content')
            ->addTab('API Settings')
                ->addFields($this->get(ApiThemeSettings::class))
            ->addTab('Color Themes')
                ->addSelect('default_theme', [
                    'allow_null' => 0,
                    'choices' => [
                        'blue_theme' => 'Blue',
                        'purple_theme' => 'Purple',
                        'pink_theme' => 'Pink',
                        'orange_theme' => 'Orange',
                        'green_theme' => 'Green'
                    ],
                    'return_format' => 'value',
                ])
                ->addGroup('blue_theme')
                    ->addFields($this->get(ThemeColorFields::class))
                ->endGroup()
                ->addGroup('purple_theme')
                    ->addFields($this->get(ThemeColorFields::class))
                ->endGroup()
                ->addGroup('pink_theme')
                    ->addFields($this->get(ThemeColorFields::class))
                ->endGroup()
                ->addGroup('orange_theme')
                    ->addFields($this->get(ThemeColorFields::class))
                ->endGroup()
                ->addGroup('green_theme')
                    ->addFields($this->get(ThemeColorFields::class))
                ->endGroup();

        return $themeSettings->build();
    }
}
