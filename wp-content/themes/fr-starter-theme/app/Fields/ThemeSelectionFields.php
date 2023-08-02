<?php
	namespace App\Fields;

	use Log1x\AcfComposer\Field;
	use StoutLogic\AcfBuilder\FieldsBuilder;

	class ThemeSelectionFields extends Field
	{
		/**
		 * The field group.
		 *
		 * @return array
		 */
		public function fields()
		{
			$fields = new FieldsBuilder('theme_selection_fields', [
				'title' => 'Theme Settings',
				'position' => 'side'
			]);

			$fields
				->setLocation('post_type', '==', 'page')
				->or('taxonomy', '==', 'age');

			$fields
				->addSelect('selected_theme', [
					'label' => 'Theme Color',
					'allow_null' => 0,
					'choices' => [
						'blue_theme' => 'Blue',
						'purple_theme' => 'Purple',
						'pink_theme' => 'Pink',
						'orange_theme' => 'Orange',
						'green_theme' => 'Green'
					],
					'return_format' => 'value',
				]);

			return $fields->build();
		}
	}