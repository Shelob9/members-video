<?php

namespace calderawp\mv\videos;


class collection {

	/**
	 * Post object
	 *
	 * @since 0.1.0
	 *
	 * @var \WP_Post
	 */
	protected $post;

	/**
	 * collection constructor.
	 *
	 * @since 0.1.0
	 *
	 * @param \WP_Post $post
	 */
	public function __construct( \WP_Post $post ) {
		$this->post = $post;
	}

	/**
	 * Get videos for this post
	 *
	 * @since 0.1.0
	 *
	 * @return mixed
	 */
	public function get_videos(){
		return get_post_meta(  $this->post->ID, 'cwpmv_files' );
	}

}