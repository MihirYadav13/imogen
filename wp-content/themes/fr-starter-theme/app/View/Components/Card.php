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
			$this->card_data = $this->getData($this->post, $this->post_type);
		}

		public function getData($post, $post_type){
			$result = [
				'title' => get_the_title($post),
				'permalink' => get_the_permalink($post),
				'excerpt' => get_the_excerpt($post),
			];

			if(in_array($post_type, ['resource', 'strategy', 'case-study'])){
				$result = array_merge($result, [
					'likes' => get_field('likes_counter', $post) ?: 0
				]);
			}

			if($post_type === 'strategy'){
				$result = array_merge($result, [
					'topics' => get_field('selected_topics', $post) ?: [],
					'keyword_tags' => get_the_terms($post, 'keyword-tag') ?: []
				]);
			}

			if($post_type === 'resource'){
                $attachment = get_field('resource_attachment', $post);
                $attachment_type = $attachment ? $attachment['type'] : '';
                $is_locked = get_field('is_locked', $post) ?: false;
				$result = array_merge($result, [
					'resource_type' => get_the_terms($post, 'resource-type') ?: [],
					'attachment_type' => $attachment_type,
                    'is_locked' => $is_locked,
                    'button_label' => $attachment_type == 'video' ? 'Watch Video' : ($is_locked ? 'Learn More' : 'Download'),
                    'button_class' => $attachment_type == 'video' ? 'video' : ($is_locked ? 'learn-more' : 'download'),
                    'modal_slug' => \App\Providers\ResourceProvider::getModalSlug(),
					'permalink' => '#' . \App\Providers\ResourceProvider::getModalSlug() . '-' . $this->post,
                    'resource_file_url' => $attachment_type == 'file' ? \App\Providers\ResourceDownloadProvider::GetResourceFileUrl($post) : false
				]);
			}

			return $result;
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
