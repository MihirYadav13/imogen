<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Header extends Composer
{
	/**
	 * List of views served by this composer.
	 *
	 * @var array
	 */
	protected static $views = [
		'sections.header'
	];

	/**
	 * Data to be passed to view before rendering.
	 *
	 * @return array
	 */
	public function with()
	{
		return [
			'logo' => get_field('header_logo', 'option'),
			'announcement_banner' => get_field('enable_announcement_banner', 'option') && strlen(get_field('enable_announcement_banner_content', 'option')) ? get_field('enable_announcement_banner_content', 'option') : false,
		];
	}
}
