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
    public function __construct($label = '', $type = '', $postId = '', $style = '', $externalUrl = false, $newTab = false, $openModal = false, $preview = false)
    {
        $this->label = $label;
        $this->preview = $preview;
        $this->url = $this->getUrl($type, $postId, $externalUrl);
        $this->target = $newTab ? '_blank' : '';
        $this->style = $style && in_array($style, $this->getStyles()) ? $style : $this->getStyles()[0]; 
    }

    protected function getUrl($type, $postId, $externalUrl){
        $result = '';
        if($type === 'externa_url'){
            $result = $externalUrl;
        }else{
            $result = get_the_permalink($postId);
        }

        return $result;
    }

    public static function getStyles(){
        return [
            'primary-arrow-right',
            'primary-arrow-down',
            'secondary-arrow-right',
            'secondary-arrow-down',
            'regular-link'
        ];
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
