<?php
// don't call the file directly.
defined( 'ABSPATH' ) || exit();

/*
 * Class CountPostView
 *
 * @since 1.0.0
 */
class CountPostView {
	/*
	 * CountPostView Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_head', array( $this, 'increment_post_views' ) );
	}

	/*
	 * Get the views of a post and page, increases it, and save it to the database.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function increment_post_views() {
		$post_id = sanitize_text_field( get_the_ID() );
		$view_count = get_post_meta( $post_id, 'post_views', true );
		$new_count =   ( $view_count ) ? $view_count + 1 : 1;
		update_post_meta( $post_id, 'post_views', $new_count );
	}
}