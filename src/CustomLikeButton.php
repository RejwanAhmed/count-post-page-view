<?php
defined( 'ABSPATH' ) || exit();

class CustomLikeButton {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'custom_like_button_scripts' ) );
		add_filter( 'the_title', array( $this, 'custom_like_button' ), 10, 2 );
		add_action( 'wp_ajax_custom_like_button_ajax', array( $this, 'custom_like_button_ajax' ) );
		add_action( 'wp_ajax_nopriv_custom_like_button_ajax', array( $this, 'custom_like_button_ajax' ) );
	}

	public function custom_like_button_scripts() {
		wp_enqueue_script( 'custom-like-button', CPPV_URL . 'assets/js/custom-like-button.js', array ( 'jquery' ), '1.0', true );
		wp_localize_script( 'custom-like-button', 'custom_like_button_ajax', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('custom-like-button-nonce')
		) );
	}

	public function custom_like_button( $title, $id ) {
		if ( is_admin() ) {
			return $title;
		}

		// This is for getting the value of show_like_button.
		$like_button_status = get_post_meta( $id, 'show_like_button', true );

		// Check if it's a post or page'
		if ( is_singular( array( 'post', 'page' ) ) && $like_button_status ) {

			$like_count  = get_post_meta( $id, 'custom_like_count', true );
			$like_button = '<button class="custom-like-button" data-post-id="' . $id . '">Like</button>';
			$title       .= ' <br>' . $like_button . ' <span style = "font-size: 18px">' . $like_count . '</span>';

		}
		return $title;

	}

	// Handle the AJAX request to update the like count
	public function custom_like_button_ajax() {
		if ( ! wp_verify_nonce( $_POST['nonce'], 'custom-like-button-nonce' ) ) {
			wp_send_json_error( 'Invalid nonce' );
		}

		$post_id = intval( $_POST['post_id'] );

		// Retrieve the current like count from the database
		$like_count = get_post_meta( $post_id, 'custom_like_count', true );

		// Increase the like count by 1
		$like_count++;

		// Update the like count in the database
		update_post_meta( $post_id, 'custom_like_count', $like_count );

		wp_send_json_success( $like_count );
	}
}