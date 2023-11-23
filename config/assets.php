<?php

    function decode_assets_file($path){       
        $fh = fopen(get_theme_file_path('public/manifest-final.json'), "w");

        $manifest = wp_json_file_decode($path);

        if($fh && $manifest){
            $aux = [];

            foreach ($manifest as $i => $m) {
                if(!is_array($m) && !is_object(json_decode(json_encode($m)))){
                    $aux[$i] = $m;
                }
            }

            fputs ($fh, json_encode($aux, JSON_UNESCAPED_SLASHES, JSON_PRETTY_PRINT));
            fclose ($fh);

            return get_theme_file_path('public/manifest-final.json');
        }

        return $path;
    }   

return [

    /*
    |--------------------------------------------------------------------------
    | Default Assets Manifest
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default asset manifest that should be used.
    | The "theme" manifest is recommended as the default as it cedes ultimate
    | authority of your application's assets to the theme.
    |
    */

    'default' => 'theme',

    /*
    |--------------------------------------------------------------------------
    | Assets Manifests
    |--------------------------------------------------------------------------
    |
    | Manifests contain lists of assets that are referenced by static keys that
    | point to dynamic locations, such as a cache-busted location. We currently
    | support two types of manifest:
    |
    | assets: key-value pairs to match assets to their revved counterparts
    |
    | bundles: a series of entrypoints for loading bundles
    |
    */

    'manifests' => [
        'theme' => [
            'path' => get_theme_file_path('public'),
            'url' => get_theme_file_uri('public'),
            'assets' => decode_assets_file(get_theme_file_path('public/app/manifest.json')),
            'bundles' => get_theme_file_path('public/app/manifest.json'),
        ]
    ]
];
