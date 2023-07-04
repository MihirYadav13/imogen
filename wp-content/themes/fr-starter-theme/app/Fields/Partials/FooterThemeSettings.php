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
            ->addImage('footer_logo', [
                'label' => 'Logo',
            ])
            ->addWysiwyg('footer_content')
            ->addFields($this->get(SocialLinks::class))
            ->addText('footer_copyright_text', [
                'wrapper' => [
                    'width' => '50'
                ],
                'prepend' => '© ',
            ])
            ->addRepeater('footer_page_links', [
                'max' => 3,
                'layout' => 'block',
            ])
                ->addLink('link')
            ->endRepeater();

        return $footerThemeSettings;
    }
}
