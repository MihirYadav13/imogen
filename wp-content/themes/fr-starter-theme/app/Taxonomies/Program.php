<?php
	return [
		'program' => [
			'hierarchical' => false,
			'links' => ['after-school-program', 'student-success'],
			'meta_box' => 'radio',
			'allow_hierarchy' => false,
			'show_in_rest' => true,
			'required' => true,
			'labels' => [
				'singular' => 'Program',
				'plural' => 'Programs',
			],
		],
	];