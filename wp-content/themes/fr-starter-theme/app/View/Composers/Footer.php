<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Footer extends Composer
{
	/**
	 * List of views served by this composer.
	 *
	 * @var array
	 */
	protected static $views = [
		'sections.footer'
	];

	/**
	 * Data to be passed to view before rendering.
	 *
	 * @return array
	 */
	public function with()
	{
		return [
			'logo' => get_field('footer_logo', 'option'),
			'tagline' => get_field('footer_caption', 'option'),
			'cta' =>  get_field('footer_cta', 'option'),
			'stock_widget' => get_field('footer_stock_widget', 'option'),
			'footer_navigation' => $this->footerNavigation(),
			'copyright_text' => date('Y') .' '. get_field('footer_copyright_text', 'option'),
			'secondary_nav' =>  get_field('footer_secondary_nav', 'option'),
		];
	}

	
	public function footerNavigation() {
		$args = [
			'theme_location' => 'footer_navigation',
			'container'  => '',
			'container_class' => '',
			'menu_class' => 'vertical-nav',
			'depth' => 0,
			'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
		];

		return $args;
	}
}
