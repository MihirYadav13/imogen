<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TeamMemberModal extends Component
{

    public $modalId;
    public $modalBody;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modalId = null)
    {
        $this->modalId = $modalId ? : uniqid('fr-modal-');
        $modalData = \App\Providers\CardsDataProvider::get(162);
		$this->modalBody = view('components.team-member.modal-body', $modalData )->render();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.team-member.modal');
    }
}
