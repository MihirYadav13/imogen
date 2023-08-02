<?php
	namespace App\Fields;

	use Log1x\AcfComposer\Field;
	use StoutLogic\AcfBuilder\FieldsBuilder;

	class CampFields extends Field
	{
		/**
		 * The field group.
		 *
		 * @return array
		 */
		public function fields()
		{
			$fields = new FieldsBuilder('camp_fields', [
				'hide_on_screen' => [
					'the_content'
				]
			]);

			$fields
				->setLocation('post_type', '==', 'camp');

			$fields
				->addImage('featured_image', [
					'wrapper' => [
						'width' => 40
					]
				])
				->addDatePicker('start_date', [
					'wrapper' => [
						'width' => 30
					],
					'return_format' => 'Y-m-d'
				])
				->addDatePicker('end_date', [
					'wrapper' => [
						'width' => 30
					],
					'return_format' => 'Y-m-d'
				])
				->addTextArea('location', [
					'maxlength' => 500,
					'rows' => 3,
					'new_line' => 'br',
					'wrapper' => [
						'width' => 80
					]
				])
				->addNumber('fee', [
					'prepend' => '$',
					'min' => 0,
					'wrapper' => [
						'width' => 20
					]
				])
				->addGroup('after_care', [
					'layout' => 'block'
				])
					->addTimePicker('start_time', [
						'wrapper' => [
							'width' => 40
						]
					])
					->addTimePicker('end_time', [
						'wrapper' => [
							'width' => 40
						]
					])
					->addNumber('fee', [
						'prepend' => '$',
						'min' => 0,
						'wrapper' => [
							'width' => 20
						]
					])
				->endGroup()				
				->addRepeater('quick_notes', [
					'max' => 5
				])
					->addText('note', [
						'maxlength' => 200
					])
				->endRepeater()
				->addLink('registration_link', [
					'wrapper' => [
						'width' => 50
					]
				]);

			return $fields->build();
		}
	}