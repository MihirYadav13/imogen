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
			'tagline' => get_field('footer_content', 'option'),
			'footerNavigation' => $this->footerNavigation(),
			'copyright_text' => get_field('footer_copyright_text', 'option'),
			'page_links' =>  get_field('footer_page_links', 'option'),
		];
	}

	
	public function footerNavigation() {
		$args = [
			'theme_location' => 'footer_navigation',
			'container'  => '',
            'container_class' => '',
            'menu_class' => 'navbar-nav me-auto mb-2 mb-lg-0',
            'depth' => 4,
            'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
            'walker' => new \App\wp_bootstrap5_navwalker()
		];

		return $args;
	}
}
