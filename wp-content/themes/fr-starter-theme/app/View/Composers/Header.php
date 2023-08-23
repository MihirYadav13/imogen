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
		$showDonate = get_field('show_donate', 'option') ? :false;
		return [
			'logo' => get_field('header_logo', 'option'),
			'announcement_banner' => get_field('enable_announcement_banner', 'option') && strlen(get_field('enable_announcement_banner_content', 'option')) ? get_field('enable_announcement_banner_content', 'option') : false,
			'donate_cta' => $showDonate ? get_field('donate_cta', 'option') : false,
			'contact_us_page' => get_field('contact_us_page', 'option')? get_permalink(get_field('contact_us_page', 'option')):false,
		];
	}
}
