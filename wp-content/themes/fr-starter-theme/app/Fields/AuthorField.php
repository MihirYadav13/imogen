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
			'title' => 'Authors',
			'position' => 'side'
		]);

		$fields
			->setLocation('post_type', '==', 'post');

		$fields
		->addUser('select_author', [
			'label' => 'Select author',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => [],
			'wrapper' => [
				'width' => '',
				'class' => '',
				'id' => '',
			],
			'role' => 'author',
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id'
		]);

		return $fields->build();
	}
}
