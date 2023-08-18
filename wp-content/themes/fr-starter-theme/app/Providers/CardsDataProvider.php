<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CardsDataProvider extends ServiceProvider
{
    const ACTION = 'get_card_modal';

    /**
     * Register any application services.
     *
     * @return void
     */
	public function register(){
		add_action('init', '\\App\Providers\CardsDataProvider::SetAjaxActions', 20);
	}

    public static function get($post){
        $post_type = get_post_type($post);

        $data = [
            'post_type' => $post_type,
            'post_id' => gettype($post) === 'integer'? $post : $post->ID,
            'permalink' => get_the_permalink($post),
            'title' => get_the_title($post),
            'featured_image' => get_field('featured_image', $post) ?:[],
            'description' => get_field('description', $post)?:'',
        ];

        if($post_type === 'after-school-program'){
            $data = array_merge($data, [
                'camp_info' => [
                    [
                        'label' => 'Program Email',
                        'value' => get_field('program_email', $post) ? '<a class="sm" href="mailto:'.get_field('program_email', $post).'">'.get_field('program_email', $post).'</a>':''
                    ],
                    [
                        'label' => 'Phone Number',
                        'value' => get_field('program_phone_number', $post) ?:''
                    ]
                ],
                'location' => get_field('location', $post) ?:'',
                'program_email' => get_field('program_email', $post) ?:'',
                'school_website' => get_field('school_website', $post) ?:[],
                'program_phone_number' => get_field('program_phone_number', $post) ?:'',
                'registration_link' => get_field('registration_link', $post) ?:false,
                'contact_us_page' => get_field('contact_us_page', 'option')? get_permalink(get_field('contact_us_page', 'option')):false,
            ]);
        }

        if($post_type === 'camp'){
            $startDate = get_field('start_date', $post) ?:false;
            $endDate = get_field('end_date', $post) ?:false;
            $hasAfterCare = get_field('has_after_care', $post)?:false;
            $afterCare = get_field('after_care', $post) ?:[];
            $quickNotes = get_field('quick_notes', $post) ?:[];

            $quickNotesText = ''; 
            foreach($quickNotes as $note){
                $quickNotesText .=  $note['note'] !== ''?$note['note'].'<br>':'';
            }

            $data = array_merge($data, [
                'camp_info' => array_filter([
                    [
                        'label' => 'Dates',
                        'value' => ( $startDate ? date("D, M d, Y", strtotime($startDate)) : '' ).' to '.( $endDate ? date("D, M d, Y", strtotime($endDate)): '')
                    ],
                    [
                        'label' => 'Camp Cost',
                        'value' => '$ '.(get_field('fee', $post) ?:'0')
                    ],
                    $hasAfterCare ? [
                        'label' => 'After Care',
                        'value' => ($afterCare['start_time']? date("h:i a", strtotime($afterCare['start_time'])):'').' to '.($afterCare['end_time']?date("h:i a", strtotime($afterCare['end_time'])) : '').'. Fee $ '.($afterCare['fee'] ?:'0')
                    ]: null,
                    [
                        'label' => 'Location',
                        'value' => (get_field('location', $post) ?:'')
                    ],
                    [
                        'label' => 'Quick Notes',
                        'value' => $quickNotesText
                    ],
                ]),
                'subheading' => get_field('subheading', $post) ?:'',
                'contact_email' => get_field('contact_email', $post) ?:'',
                'quick_notes' => get_field('quick_notes', $post) ?:'',
                'registration_link' => get_field('registration_link', $post) ?:false,        
                'contact_us_page' => get_field('contact_us_page', 'option')? get_permalink(get_field('contact_us_page', 'option')):false,
            ]);
        }

        if($post_type === 'post'){
            $featuredImage = get_the_post_thumbnail_url($post, 'full');
            $data = array_merge($data, [
                'featured_image' => $featuredImage? [
                    'url' => $featuredImage
                ] : [],
                'action_cta' => [
                    'url' => $data['permalink'],
                    'title' => 'Learn More',
                    'style' => 'regular-link'
                ]
            ]);
        }

        if($post_type === 'team-member'){
            $data = array_merge($data, [
                'role' => get_field('role', $post) ?:'',
                'featured_image' => get_field('profile_photo', $post) ?:[],
                'short_bio' => get_field('short_bio', $post) ?:'',
            ]);
        }

        // Add featured image
        $data = array_merge($data, [
            'is_empty_featured_image' => empty($data['featured_image'])?true:false,
            'featured_image' => (!empty($data['featured_image']) ? $data['featured_image'] : [
                'url' => asset('images/default-card.png')
            ]),
        ]);


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

    

	public static function SetAjaxActions(){
		add_action('wp_ajax_' . self::ACTION, function(){
			return self::GetModalAjax();
		});

		add_action('wp_ajax_nopriv_' . self::ACTION, function(){
			return self::GetModalAjax();
		});
	}

    public static function getAjaxConfig(){
        $ajax_config = [
            'url' => home_url('/', is_ssl() ? 'https' : 'http') . 'wp-admin/admin-ajax.php',
            'action' => self::ACTION
	    ];

		return json_encode($ajax_config, JSON_HEX_APOS);
    }


	public static function GetModalAjax(){
		$postId = filter_input(INPUT_GET, 'postId')?: false;
		if(!$postId){
			wp_send_json_error();
			die();
		}

		$modalData = self::get($postId);
		$modalBody = view('components.card-modal.modal-body', $modalData )->render();
		wp_send_json_success(['modalBody' => $modalBody]);
	}
}
