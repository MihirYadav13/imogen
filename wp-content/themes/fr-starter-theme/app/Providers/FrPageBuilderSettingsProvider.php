<?php

	namespace App\Providers;

	use Roots\Acorn\ServiceProvider;

	class FrPageBuilderSettingsProvider extends ServiceProvider
	{
		/**
		 * Register services.
		 *
		 * @return void
		 */
		public function register()
		{
			add_filter('acf/register_block_type_args', '\\App\Providers\FrPageBuilderSettingsProvider::addCustomIcon');
		}

		public static function addCustomIcon ($args){
			$path = get_template_directory() . '/resources/block-icons/' . str_replace("acf/", "", $args['name']) . '.svg';
			if(file_exists($path)){
				$args['icon'] =  preg_replace("/<\\?xml.*\\?>/", '', file_get_contents($path, FILE_USE_INCLUDE_PATH), 1);
			}

			return $args;
		}
	}
