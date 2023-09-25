<?php
return [
	'age' => [
		'hierarchical' => true,
		'links' => ['after-school-program', 'camp', 'post', 'childhood-education'],
		'allow_hierarchy' => false,
		'show_in_rest' => true,
		'required' => true,
		'labels' => [
			'singular' => 'Age',
			'plural' => 'Age',
		],
	],
];
