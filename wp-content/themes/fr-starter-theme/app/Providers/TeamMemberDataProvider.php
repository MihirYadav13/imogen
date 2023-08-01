<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TeamMemberDataProvider extends ServiceProvider
{
	const ACTION = 'get_team_member_modal';

    /**
     * Register any application services.
     *
     * @return void
     */
	public function register(){
		add_action('init', '\\App\Providers\TeamMemberDataProvider::SetAjaxActions', 20);
	}

	public static function SetAjaxActions(){
		add_action('wp_ajax_' . self::ACTION, function(){
			return self::GetMemberModalAjax();
		});

		add_action('wp_ajax_nopriv_' . self::ACTION, function(){
			return self::GetMemberModalAjax();
		});
	}

    public static function getAjaxConfig(){
        $ajax_config = [
            'url' => home_url('/', is_ssl() ? 'https' : 'http') . 'wp-admin/admin-ajax.php',
            'action' => self::ACTION
	    ];

		return json_encode($ajax_config, JSON_HEX_APOS);
    }


	public static function GetMemberModalAjax(){
		$memberId = filter_input(INPUT_GET, 'memberId')?: false;
		if(!$memberId){
			wp_send_json_error();
			die();
		}

		$modalData = \App\Providers\CardsDataProvider::get($memberId);
		$modalBody = view('components.team-member.modal-body', $modalData )->render();
		wp_send_json_success(['modalBody' => $modalBody]);
	}
}
