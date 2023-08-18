<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class AuthorField extends Field
{
	/**
	 * The field group.
	 *
	 * @return array
	 */
	public function fields()
	{
		$fields = new FieldsBuilder('author_field', [
			'title' => 'Show Author',
			'position' => 'side'
		]);

		$fields
			->setLocation('post_type', '==', 'post');

		$fields
		->addRadio('show_author', [
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
