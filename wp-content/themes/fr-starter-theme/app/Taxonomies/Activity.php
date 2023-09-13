<?php
	return [
		'activity' => [
			'hierarchical' => true,
			'links' => ['after-school-program', 'camp', 'post'],
			'allow_hierarchy' => false,
			'show_in_rest' => true,
			'required' => true,
			'labels' => [
				'singular' => 'Activity',
				'plural' => 'Activities',
			],
		],
	];