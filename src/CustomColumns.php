<?php
defined( 'ABSPATH' ) || exit();

class CustomColumns {
	public function __construct() {
		add_filter( 'manage_post_posts_columns', array( $this, 'posts_pages_custom_columns' ) );
		add_filter( 'manage_page_posts_columns', array( $this, 'posts_pages_custom_columns' ) );

		add_action( 'manage_post_posts_custom_column', array( $this, 'display_posts_pages_total_likes' ), 10, 2 );
		add_action( 'manage_page_posts_custom_column', array( $this, 'display_posts_pages_total_likes' ), 10, 2 );
	}

	public function posts_pages_custom_columns( $columns ) {
		$new_columns = array();
		foreach ( $columns as $key => $value ) {
			$new_columns[$key] = $value;
			if ( $key === 'title' ) {
				$new_columns['custom_like_count'] = 'Total Likes';
			}
		}
		return $new_columns;
	}

	public function display_posts_pages_total_likes( $column, $post_id ) {
		if ( $column === 'custom_like_count' ) {
			$total_likes = get_post_meta( $post_id, 'custom_like_count', true );
			$total_likes = ($total_likes > 0) ? $total_likes : 0;
			echo $total_likes;
		}
	}
}