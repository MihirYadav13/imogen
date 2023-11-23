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
		->addTrueFalse('show_author', [
			'label' => '',
			'default_value' => 0
		]);

		return $fields->build();
	}
}
