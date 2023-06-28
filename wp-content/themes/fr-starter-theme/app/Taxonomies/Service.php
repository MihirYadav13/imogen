<?php
	return [
		'service' => [
			'hierarchical' => true, 
			'links' => ['project'],
			'meta_box' => 'simple',
			'allow_hierarchy' => true,
			'labels' => [
				'singular' => 'Project Type',
				'plural' => 'Project Types',
			],
		],
	];