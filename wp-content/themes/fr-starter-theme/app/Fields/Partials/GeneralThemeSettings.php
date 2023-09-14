<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class GeneralThemeSettings extends Partial
{
    /**
     * The partial field group.
     *
     * @return \StoutLogic\AcfBuilder\FieldsBuilder
     */
    public function fields()
    {
        $fields = new FieldsBuilder('general_theme_settings');

        $fields
            ->addPostObject('contact_us_page', [
                'label' => 'Contact Us Page',
                'post_type' => [
                    'page'
                ],
                'wrapper' => [
                    'width' => '50'
                ],
                'multiple' => 0,
                'return_format' => 'id',
                'required' => 1
            ])
            ->addPostObject('load_more_url', [
                'label' => 'Blog Page',
                'post_type' => [
                    'page'
                ],
                'wrapper' => [
                    'width' => '50'
                ],
                'multiple' => 0,
                'return_format' => 'id',
                'required' => 1
            ]);

        return $fields;
    }
}
