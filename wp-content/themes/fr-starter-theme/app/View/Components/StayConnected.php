<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StayConnected extends Component
{
    public $title;
    public $content;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->title = get_field('stay_connected_title', 'option');
        $this->content = get_field('stay_connected_content', 'option');
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.stay-connected');
    }
}
