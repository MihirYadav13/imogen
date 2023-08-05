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
				->addDatePicker('start_date', [
					'wrapper' => [
						'width' => 20
					],
					'return_format' => 'Y-m-d'
				])
				->addDatePicker('end_date', [
					'wrapper' => [
						'width' => 20
					],
					'return_format' => 'Y-m-d'
				])
				->addNumber('fee', [
					'prepend' => '$',
					'min' => 0,
					'wrapper' => [
						'width' => 20
					]
				])
				->addImage('featured_image', [
					'wrapper' => [
						'width' => 40
					]
				])
				->addText('subheading', [
					'maxlength' => 500,
					'wrapper' => [
						'width' => 50
					]
				])
				->addText('contact_email', [
					'required' => 1,
					'maxlength' => 50,
					'wrapper' => [
						'width' => 50
					]
				])
				->addTextArea('description', [
					'maxlength' => 1000,
					'rows' => 3,
					'new_line' => 'br',
					'wrapper' => [
						'width' => 50
					]
				])
				->addTextArea('location', [
					'maxlength' => 500,
					'rows' => 3,
					'new_line' => 'br',
					'wrapper' => [
						'width' => 50
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