<?php
	namespace App\Fields;

	use Log1x\AcfComposer\Field;
	use StoutLogic\AcfBuilder\FieldsBuilder;

	class AfterSchoolProgramFields extends Field
	{
		/**
		 * The field group.
		 *
		 * @return array
		 */
		public function fields()
		{
			$fields = new FieldsBuilder('after_school_program_fields', [
				'hide_on_screen' => [
					'the_content'
				]
			]);

			$fields
				->setLocation('post_type', '==', 'after-school-program');

			$fields
				->addImage('featured_image', [
					'required' => 1
				])
				->addTextArea('description', [
					'required' => 1,
					'maxlength' => 1000,
					'rows' => 3,
					'new_line' => 'br',
					'wrapper' => [
						'width' => 50
					]
				])
				->addTextArea('location', [
					'rows' => 3,
					'new_line' => 'br',
					'maxlength' => 500,
					'wrapper' => [
						'width' => 50
					]
				])
				->addText('program_email', [
					'required' => 1,
					'maxlength' => 50,
					'wrapper' => [
						'width' => 50
					]
				])
				->addText('program_phone_number', [
					'required' => 1,
					'maxlength' => 50,
					'wrapper' => [
						'width' => 50
					]
				])
				->addLink('school_website', [
					'wrapper' => [
						'width' => 50
					]
				])
				->addUrl('registration_link', [
					'required' => 1,
					'wrapper' => [
						'width' => 50
					]
				]);

			return $fields->build();
		}
	}