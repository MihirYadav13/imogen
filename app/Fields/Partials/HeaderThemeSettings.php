<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\CtaButtonFields;

class HeaderThemeSettings extends Partial
{
    /**
     * The partial field group.
     *
     * @return \StoutLogic\AcfBuilder\FieldsBuilder
     */
    public function fields()
    {
        $headerThemeSettings = new FieldsBuilder('header_theme_settings');

        $headerThemeSettings
            ->addMessage('Header Note', 'Go to Appereance > Menus to customize the main menu')
            ->addImage('header_logo', [
                'wrapper' => [
                    'width' => 30
                ]
            ])
            ->addTrueFalse('show_donate')
            ->addGroup('donate_cta')
                ->conditional('show_donate', '==', 1)
                ->addFields($this->get(CtaButtonFields::class))
            ->endGroup()
            ->addTextarea('google_tag_manager_code_snippet', [
                'rows' => 3
            ])
            ->addTextarea('additional_google_tag_manager_code_snippet', [
                'rows' => 2
            ]);

        return $headerThemeSettings;
    }
}
