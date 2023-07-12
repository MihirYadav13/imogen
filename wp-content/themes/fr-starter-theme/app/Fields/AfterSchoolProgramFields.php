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
					'wrapper' => [
						'width' => 50
					]
				])
				->addText('location', [
					'maxlength' => 50,
					'wrapper' => [
						'width' => 50
					]
				])
				->addText('school_email', [
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
				->addText('school_phone_number', [
					'maxlength' => 50,
					'wrapper' => [
						'width' => 50
					]
				])
				->addLink('registration_link', [
					'wrapper' => [
						'width' => 50
					]
				]);

			return $fields->build();
		}
	}