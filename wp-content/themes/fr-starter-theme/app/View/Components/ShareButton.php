<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShareButton extends Component
{

    public $post;
    public $links;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($post = false)
    {
        if(!$post){
            $this->post = get_the_ID();
        }

		if($post instanceof \WP_Post) {
			$this->post = $post->ID;
		}

        $this->links = $this->getLinksArray();
    }


    protected function getLinksArray() {
        $page_url = get_the_permalink($this->post);
        $page_title = get_the_title($this->post);
    
        // Create Array with Social Sharing links.
        $links = array(
            'facebook' => [
                'class' => 'facebook-share',
                'url'  => 'https://www.facebook.com/sharer/sharer.php?u=' . $page_url . '&t=' . $page_title,
                'text' => 'Share on Facebook',
            ],
            'twitter' => [
                'class' => 'twitter-share',
                'url'  => 'https://twitter.com/intent/tweet?text=' . $page_title . '&url=' .$page_url,
                'text' => 'Share on Twitter',
            ],
            'Email' => array(
                'class' => 'envelope',
                'url'  => 'mailto:name1@rapidtables.com?subject='.$page_title.'&body='.$page_url,
                'text' => 'Mail to',
            ),
            'link' => array(
                'class' => 'link-share',
                'url'  => $page_url,
                'text' => 'Copy Link',
            )
        );
    
        return $links;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.share-button');
    }
}
