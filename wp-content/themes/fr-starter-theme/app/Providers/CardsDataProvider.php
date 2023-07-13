<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CardsDataProvider extends ServiceProvider
{
    public static function get($post){
        $post_type = get_post_type($post);

        $data = [
            'post_type' => $post_type,
            'permalink' => get_the_permalink($post),
            'title' => get_the_title($post),
            'featured_image' => get_field('featured_image', $post) ?:[],
            'excerpt' => get_the_excerpt($post),
        ];

        if($post_type === 'after-school-program'){
            $data = array_merge($data, [
                'location' => get_field('location', $post) ?:'',
                'school_email' => get_field('school_email', $post) ?:'',
                'school_website' => get_field('school_website', $post) ?:[],
                'school_phone_number' => get_field('school_phone_number', $post) ?:'',
                'registration_link' => get_field('registration_link', $post) ?:[],
            ]);
        }

        if($post_type === 'camp'){
            $data = array_merge($data, [
                'start_date' => get_field('start_date', $post) ?:false,
                'end_date' => get_field('end_date', $post) ?:false,
                'location' => get_field('location', $post) ?:'',
                'fee' => get_field('fee', $post) ?:'',
                'after_care' => get_field('after_care', $post) ?:[],
                'quick_notes' => get_field('quick_notes', $post) ?:[],
                'registration_link' => get_field('registration_link', $post) ?:[]            ]);
        }

        if($post_type === 'team-member'){
            $data = array_merge($data, [
                'role' => get_field('role', $post) ?:'',
                'featured_image' => get_field('profile_photo', $post) ?:[],
                'short_bio' => get_field('short_bio', $post) ?:'',
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
