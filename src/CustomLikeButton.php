<?php
defined( 'ABSPATH' ) || exit();

class CustomLikeButton {
	public function __construct() {
		add_filter( 'the_title', array( $this, 'custom_like_button' ), 10, 2 );
	}

	public function custom_like_button( $title, $id = NULL ) {
		if ( is_admin() ) {
			return $title;
		}

		if ( is_singular( array( 'post', 'page' ) ) ) {

			$like_count = get_post_meta($id, 'custom_like_count', true);
			$like_button = '<button class="custom-like-button" data-post-id="' . $id . '">Like</button>';
			$title .= ' ' . $like_button . $like_count ;
		}
		return $title;
	}

}