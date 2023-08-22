<?php
	namespace App\Fields;

	use Log1x\AcfComposer\Field;
	use StoutLogic\AcfBuilder\FieldsBuilder;

	class PostFields extends Field
	{
		/**
		 * The field group.
		 *
		 * @return array
		 */
		public function fields()
		{
			$fields = new FieldsBuilder('card_description', [
				'hide_on_screen' => [
					'the_content'
				],
				'position' => 'side'
			]);

			$fields
				->setLocation('post_type', '==', 'post');

			$fields
				->addTextArea('description', [
					'required' => 1,
					'maxlength' => 1000,
					'rows' => 3,
					'new_line' => 'br',
					'wrapper' => [
						'width' => 50
					]
				]);

			return $fields->build();
		}
	}