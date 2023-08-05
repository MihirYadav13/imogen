<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardModal extends Component
{

    public $modalId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modalId = null)
    {
        $this->modalId = $modalId ? : uniqid('fr-modal-');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card-modal.modal');
    }
}
