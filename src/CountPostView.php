<?php

defined( 'ABSPATH' ) || exit();

class CountPostView {
	public function __construct() {
		add_action( 'wp_head', array( $this, 'increment_post_views' ) );
	}

	public function increment_post_views() {
		$post_id = get_the_ID();
		$view_count = get_post_meta( $post_id, 'post_views', true );
		$new_count =   ( $view_count ) ? $view_count + 1 : 1;
		update_post_meta( $post_id, 'post_views', $new_count );
	}
}