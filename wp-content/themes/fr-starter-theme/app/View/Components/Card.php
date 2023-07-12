<?php
	namespace App\View\Components;

	use Illuminate\View\Component;

	class Card extends Component
	{

		public $post;
		public $post_type;
		public $card_data;

		/**
		 * Create a new component instance.
		 *
		 * @return void
		 */
		public function __construct($post = null)
		{
			$this->post = $post instanceof \WP_Post ? $post->ID : $post;
			$this->post_type = get_post_type($this->post);
			$this->card_data = \App\Providers\CardsDataProvider::get($this->post, $this->post_type);
		}

		/**
		 * Get the view / contents that represent the component.
		 *
		 * @return \Illuminate\Contracts\View\View|\Closure|string
		 */
		public function render()
		{
			return view('components.card');
		}
	}
