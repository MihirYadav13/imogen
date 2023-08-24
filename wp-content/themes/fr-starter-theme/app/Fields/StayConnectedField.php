<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class StayConnectedField extends Field
{
	/**
	 * The field group.
	 *
	 * @return array
	 */
	public function fields()
	{
		$fields = new FieldsBuilder('stay_connected_field', [
			'title' => 'Show Stay Connected',
			'position' => 'side'
		]);

		$fields
			->setLocation('post_type', '==', 'page');

		$fields
		->addRadio('show_sconnected', [
			'label' => '',
			'layout' => 'horizontal',
			'wpml_cf_preferences' => 0,
			'choices' => [
				'default' => 'Yes',
				'No_value' => 'No',
			],
			'default_value' => 'default'
		]);

		return $fields->build();
	}
}
