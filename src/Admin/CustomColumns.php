<?php
// don't call the file directly.
defined( 'ABSPATH' ) || exit();

/*
 * Class CustomColumns
 *
 * @since 1.0.0
 */
class CustomColumns {

	/*
	 * CustomColumns Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'manage_post_posts_columns', array( $this, 'posts_pages_custom_columns' ) );
		add_filter( 'manage_page_posts_columns', array( $this, 'posts_pages_custom_columns' ) );

		add_action( 'manage_post_posts_custom_column', array( $this, 'display_posts_pages_total_likes' ), 10, 2 );
		add_action( 'manage_page_posts_custom_column', array( $this, 'display_posts_pages_total_likes' ), 10, 2 );
	}

	/*
	 * Inserts the Total Likes column after the title column of a post and page
	 *
	 * @param $columns The name of all columns of posts and pages
	 *
	 * @since 1.0.0
	 * @return $new_columns
	 */
	public function posts_pages_custom_columns( $columns ) {
		$new_columns = array();
		foreach ( $columns as $key => $value ) {
			$new_columns[$key] = $value;
			if ( $key === 'title' ) {
				$new_columns['custom_like_count'] = esc_html__( 'Total Likes', 'count-post-page-view' );
			}
		}
		return $new_columns;
	}

	/*
	 * Gets the value from the database of custom_like_count of every posts or pages
	 *
	 * @param $column The name of all columns
	 *
	 * @param $post_id
	 *
	 * @since 1.0.0
	 */
	public function display_posts_pages_total_likes( $column, $post_id ) {
		if ( $column === 'custom_like_count' ) {
			$total_likes = sanitize_text_field( get_post_meta( $post_id, 'custom_like_count', true ) );
			$total_likes = ( $total_likes > 0 ) ? $total_likes : 0;
			echo esc_html__( $total_likes, 'count-post-page-view' );
		}
	}
}