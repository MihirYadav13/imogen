<?php
	namespace App\Fields;

	use Log1x\AcfComposer\Field;
	use StoutLogic\AcfBuilder\FieldsBuilder;

	class TeamMemberFields extends Field
	{
		/**
		 * The field group.
		 *
		 * @return array
		 */
		public function fields()
		{
			$fields = new FieldsBuilder('team_member_fields', [
				'hide_on_screen' => [
					'the_content'
				]
			]);

			$fields
				->setLocation('post_type', '==', 'team-member');

			$fields
				->addImage('profile_photo', [
					'required' => 1,
					'wrapper' => [
						'width' => 50
					]
				])
				->addText('role', [
					'required' => 1,
					'maxlength' => 50,
					'wrapper' => [
						'width' => 50
					]
				])
				->addWysiwyg('short_bio', [
					'rows' => 5,
					'new_line' => 'br',
					'maxlength' => 700
				]);

			return $fields->build();
		}
	}