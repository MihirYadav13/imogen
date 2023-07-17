<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class CardGridFilters extends Partial
{
	/**
	 * The partial field group.
	 *
	 * @return \StoutLogic\AcfBuilder\FieldsBuilder
	 */
	public function fields()
	{
		$cardGridFilters = new FieldsBuilder('card_grid_filters');

		$cardGridFilters
		->addRadio('post_type', [
			'choices' => [
				'after-school-program' => 'After School Program',
				'camp' => 'Camp',
				'sudent-success' => 'Student Success',
				'childhood-education' => 'Childhood Education',
				'team-member' => 'Team Member'
			],
			'required' => 1,
			'layout' => 'horizontal',
			'wrapper' => [
				'width' => 100
			]
		])
		->addGroup('taxonomies', [
			'layout' => 'block'
		])
			->addTaxonomy('age', [
				'label' => 'Age',
				'taxonomy' => 'age',
				'field_type' => 'checkbox',
				'return_format' => 'object',
				'multiple' => 1,
				'add_term' => 0,
				'wrapper' => [
					'width' => 50
				]
			])
				->conditional('post_types', '==', 'after-school-program')
				->or('post_types', '==', 'student-success')
			->addTaxonomy('program', [
				'label' => 'Programs',
				'taxonomy' => 'program',
				'field_type' => 'checkbox',
				'return_format' => 'object',
				'multiple' => 1,
				'add_term' => 0,
				'wrapper' => [
					'width' => 50
				]
			])
				->conditional('post_types', '==', 'after-school-program')
				->or('post_types', '==', 'student-success')
		->endGroup();

		return $cardGridFilters;
	}
}
