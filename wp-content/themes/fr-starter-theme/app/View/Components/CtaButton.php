<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CtaButton extends Component
{

	public $label;
	public $type;
	public $postId;
	public $externalUrl;
	public $newTab;
	public $openModal;
	public $style;
	public $url;
	public $target;
	public $preview;

	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct($label = '', $type = '', $postId = '', $style = '', $externalUrl = false, $anchor = false, $newTab = false, $preview = false)
	{
		$this->label = $label;
		$this->preview = $preview;
		$this->url = $this->getUrl($type, $postId, $externalUrl, $anchor);
		$this->target = $newTab ? '_blank' : '';
		$this->style = $this->getStyleClass($style && in_array($style, $this->getStyles()) ? $style : $this->getStyles()[0]); 
	}

	protected function getUrl($type, $postId, $externalUrl, $anchor){
		$result = 'post_id';

		if($type === 'external_url'){
			$result = $externalUrl;
		}else if ($type === 'post_id') {
			$result = get_the_permalink($postId);
		}else if ($type === 'anchor') {
			$result = '#' . str_replace('#', '', $anchor);
		}

		return $result;
	}

	public static function getStyles(){
		return [
			'primary',
			'secondary',
			'terciary',
			'regular-link'
		];
	}
	
	protected function getStyleClass($style){
		return $style == 'regular-link' ? 'cta-regular' : 'cta-button ' . $style;
	}

	/**
	 * Get the view / contents that represent the component.
	 *
	 * @return \Illuminate\Contracts\View\View|\Closure|string
	 */
	public function render()
	{
		return view('components.cta-button');
	}
}
