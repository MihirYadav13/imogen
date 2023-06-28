<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PostTemplatesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(){
        add_action('init', '\\App\Providers\PostTemplatesProvider::SetTemplates', 20);
    }

    public static function SetTemplates(){
        self::SetPageTemplate();
        self::SetPostTemplate();
    }

    public static function SetPageTemplate(){
        $page = get_post_type_object('page');

        $page->template = [
            ['acf/fr-page-builder', [], [
                ['acf/block-container', [], [
                    ['acf/fr-page-builder-module-wysiwyg']
                ]]
            ]]
        ];
    }

    public static function SetPostTemplate(){
        $page = get_post_type_object('post');

        $page->template = [
            ['acf/fr-page-builder', [], [
                ['acf/block-container', [], [
                    ['acf/fr-page-builder-module-wysiwyg']
                ]]
            ]]
        ];
    }
}
