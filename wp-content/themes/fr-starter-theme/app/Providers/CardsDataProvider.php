<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CardsDataProvider extends ServiceProvider
{
    public static function get($post){
        $post_type = get_post_type($post);

        $data = [
            'post_type' => $post_type,
            'permalink' => [
                'url' => get_the_permalink($post),
                'target' => ''
            ],
            'title' => get_the_title($post),
            'excerpt' => get_the_excerpt($post),
        ];

        if($post_type == 'project'){
            $data = array_merge($data, [
                'image' => [
                    'url' => wp_get_attachment_url(get_post_thumbnail_id($post), 'thumbnail') ? wp_get_attachment_url(get_post_thumbnail_id($post), 'thumbnail') : wp_get_attachment_image_url(self::getHeroImage($post), 'large'),
                    'alt' => $data['title']
                ],
                'tag' => get_field('country', $post)
            ]);
        }

        return $data;
    }

    public static function getPrimaryTermByTaxonomy($post_id, $taxonomy){
        if($post_id instanceof \WP_Post) {
            $post_id = $post_id->ID;
        }

        $primary_id = function_exists('yoast_get_primary_term_id') ? yoast_get_primary_term_id($taxonomy, $post_id) : false;
        if($primary_id){
            $result = get_term_by('id', $primary_id, $taxonomy);
        }else{
            $result = wp_get_post_terms($post_id, $taxonomy);
        }

        return $result;
    }

    public static function getHeroImage($post_id){
        if($post_id instanceof \WP_Post) {
            $post_id = $post_id->ID;
        }
        $post = get_post($post_id);
        $blocks = parse_blocks($post->post_content);

        foreach ($blocks as $block) {
            if($block['blockName'] == 'acf/fr-page-builder'){
                if($block['innerBlocks'] && count($block['innerBlocks'])){
                    foreach ($block['innerBlocks'] as $innerBlock) {
                        if($innerBlock['blockName'] == 'acf/hero'){
                            if(isset($innerBlock['attrs']['data']['background_image'])){
                                return $innerBlock['attrs']['data']['background_image'];
                            }
                        }
                    }
                }
            }
        }
    }
}
