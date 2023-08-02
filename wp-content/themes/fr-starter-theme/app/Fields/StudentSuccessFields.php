<?php
	namespace App\Fields;

	use Log1x\AcfComposer\Field;
	use StoutLogic\AcfBuilder\FieldsBuilder;

	class StudentSuccessFields extends Field
	{
		/**
		 * The field group.
		 *
		 * @return array
		 */
		public function fields()
		{
			$fields = new FieldsBuilder('student_success_fields', [
				'hide_on_screen' => [
					'the_content'
				]
			]);

			$fields
				->setLocation('post_type', '==', 'student-success');

			$fields
				->addImage('featured_image', [
					'wrapper' => [
						'width' => 50
					]
				]);

			return $fields->build();
		}
	}