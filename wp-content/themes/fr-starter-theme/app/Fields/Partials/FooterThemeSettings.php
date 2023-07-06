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
                'wrapper' => [
                    'width' => '50'
                ]
            ])
            ->addWysiwyg('footer_content',[
                'wrapper' => [
                    'width' => '50'
                ]
            ])
            ->addText('subscribe_label', [
                'wrapper' => [
                    'width' => '50'
                ]
            ])
            ->addText('subscribe_form_shortcode', [
                'wrapper' => [
                    'width' => '50'
                ]
            ])
            ->addText('follow_us_label', [
                'wrapper' => [
                    'width' => '50'
                ]
            ])
            ->addFields($this->get(SocialLinks::class))
            ->addText('footer_copyright_text', [
                'wrapper' => [
                    'width' => '50'
                ],
                'prepend' => '© ',
            ])
            ->addPostObject('footer_page_links', [
                'label' => 'Page links',
                'post_type' => 'page',
                'return_format' => 'id',
                'multiple' => 1,
                'wrapper' => [
                    'width' => 50
                ]
            ]);

        return $footerThemeSettings;
    }
}
