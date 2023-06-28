<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
	return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

add_filter( 'wpseo_metabox_prio', function() {
	return 'low';
});

// Filter for validations of acf block editor fields
add_action( 'acf/validate_save_post', function () {
	// bail early if no $_POST
	$acf = false;
	foreach($_POST as $key => $value) {
		if (strpos($key, 'acf') === 0) {
			if (! empty( $_POST[$key] ) ) {
				acf_validate_values( $_POST[$key], $key);
			}
		}
	}
}, 5 );
