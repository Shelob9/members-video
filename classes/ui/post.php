<?php


namespace calderawp\mv\ui;


class post {

	/**
	 * @var string
	 */
	protected $prefix = 'cwpmv';

	/**
	 * @var \CMB2
	 */
	protected $cmb;

	/**
	 * post constructor.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		add_action( 'cmb2_admin_init', array( $this, 'make_ui' ), 5 );

	}

	/**
	 * Make UI go
	 *
	 * @since 0.1.0
	 */
	public function make_ui(){
		$this->create_metabox();
		$this->videos_field();
	}

	/**
	 * Create metabox
	 *
	 * @since 0.1.0
	 */
	protected function create_metabox(){
		$this->cmb = new_cmb2_box( array(
			'id'            => $this->prefix,
			'title'         => __( 'Members Video', 'members-video' ),
			'object_types'  => apply_filters( 'cwp_mv_show_post_types', array( 'post' ) ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'cmb_styles' => true,

		) );

	}

	/**
	 * Add videos field to metabox
	 *
	 * @since 0.1.0
	 */
	protected function videos_field(){
		$this->cmb->add_field( array(
			'name' => __( 'Videos', 'members-video' ),
			'desc' => '',
			'id'   => $this->prefix . '_files',
			'type' => 'file_list',
			'preview_size' => array( 100, 100 ),
			'text' => array(
				'add_upload_files_text' => __( 'Add Video', 'members-video' ),
				'remove_image_text' => __( 'Remove Video', 'members-video' ),
			),
		) );

	}

}