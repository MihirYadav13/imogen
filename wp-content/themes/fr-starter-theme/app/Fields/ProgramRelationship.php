<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ProgramRelationship extends Field
{
	/**
	 * The field group.
	 *
	 * @return array
	 */
	public function fields()
	{
		$fields = new FieldsBuilder('program_relationship', [
			'title' => 'Programs',
			'position' => 'side'
		]);

		$fields
			->setLocation('post_type', '==', 'post');

		$fields
		->addRadio('program_type', [
			'choices' => [
				'after-school-program' => 'After School',
				'camp' => 'Camp'
			],
			'wpml_cf_preferences' => 0,
			'return_format' => 'value',
			'default' => 'after-school-program'
		])
		->addPostObject('related_program', [
			'label' => 'Select Programs',
			'post_type' => [
				'after-school-program'
			],
			'required' => 1,
			'multiple' => 1
		])
			->conditional('program_type', '==', 'after-school-program')
		->addPostObject('related_camp', [
			'label' => 'Select Programs',
			'post_type' => [
				'camp'
			],
			'required' => 1,
			'multiple' => 1
		])
			->conditional('program_type', '==', 'camp');

		return $fields->build();
	}
}
