<?php
/**
 * Plugin Name: Members Vido
 * Plugin URI:  https://CalderaWP.com/
 * Description: BrainTree for Caldera Forms
 * Version: 1.1.0
 * Author:      Josh Pollock for CalderaWP LLC
 * Author URI:  https://CalderaWP.com
 * License:     GPLv2+
 * Text Domain: members-video
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2016 Josh Pollock for CalderaWP LLC (email : Josh@CalderaWP.com) for CalderaWP LLC
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


class CWP_MV {

	protected $html;

	public function __construct() {
		$this->autoloader();
		if( is_admin() ) {
			$this->boot_admin();
		}else{
			add_action( 'template_redirect', array( $this, 'display' ) );
		}
	}

	protected function boot_admin(){
		$this->cmb2();
		new \calderawp\mv\admin();
	}

	protected function cmb2(){
		include __DIR__ .'/cmb2/init.php';
	}

	public function display(){
		$post = get_post();

		/**
		 * Show videos on a post
		 *
		 * @since 0.1.0
		 *
		 * @param bool $show To show or not. Default is false.
		 * @param WP_Post $post Current post object
		 */
		if( is_single( $post ) && apply_filters( 'cwp_mv_show_videos', false, $post ) ){
			$collection = new \calderawp\mv\videos\collection( $post );
			$videos = $collection->get_videos();
			if( ! empty( $videos ) ){
				$display = new \calderawp\mv\videos\display( $videos );
				$this->html = $display->get_html();
				add_filter( 'the_content', function( $content ){
					return $content . $this->html;
				});

			}

		}

	}

	protected function autoloader(){
		spl_autoload_register(function ($class) {
			$prefix = 'calderawp\\mv\\';
			$base_dir = __DIR__ . '/classes/';
			$len = strlen($prefix);
			if (strncmp($prefix, $class, $len) !== 0) {
				return;
			}
			$relative_class = substr($class, $len);
			$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
			if (file_exists($file)) {
				require $file;
			}

		});
	}
}

new CWP_MV();