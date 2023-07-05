<?php
// don't call the file directly.
defined( 'ABSPATH' ) || exit();

/*
 * Class CustomLikeButton
 *
 * @since 1.0.0
 */
class CustomLikeButton {

	/*
	 * CustomLikeButton Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'custom_like_button_scripts' ) );
		add_filter( 'the_title', array( $this, 'custom_like_button' ), 10, 2 );
		add_action( 'wp_ajax_custom_like_button_ajax', array( $this, 'custom_like_button_ajax' ) );
		add_action( 'wp_ajax_nopriv_custom_like_button_ajax', array( $this, 'custom_like_button_ajax' ) );
	}

	/*
	 * Enqueues the js file
	 *
	 * transfers the data of php to javascript
	 *
	 * @since 1.0.0
	 */
	public function custom_like_button_scripts() {
		wp_enqueue_script( 'custom-like-button', CPPV_URL . 'assets/js/custom-like-button.js', array ( 'jquery' ), '1.0', true );

		// This functio is used to transfer the data from php to javascript
		wp_localize_script( 'custom-like-button', 'custom_like_button_ajax', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('custom-like-button-nonce')
		) );
	}

	/*
	 * shows the like button under the title of a post and page
	 *
	 * @param $title The title of the post or page
	 *
	 * @param $id ID of the post or page
	 *
	 * @since 1.0.0
	 * @return title
	 */
	public function custom_like_button( $title, $id ) {
		if ( is_admin() ) {
			return $title;
		}

		// This is for getting the value of show_like_button.
		$like_button_status = get_post_meta( $id, 'show_like_button', true );

		// Check if it's a post or page'
		if ( is_singular( array( 'post', 'page' ) ) && $like_button_status ) {

			$like_count  = get_post_meta( $id, 'custom_like_count', true );
			$like_button = '<button class="custom-like-button" data-post-id="' . esc_attr( $id ) . '">Like</button>';
			$title       .= ' <br>' . $like_button . ' <span style = "font-size: 18px">' . esc_html( $like_count ) . '</span>';

		}
		return $title;

	}

	/*
	 * Handle the AJAX request to update the like count
	 *
	 * @since 1.0.0
	 */
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