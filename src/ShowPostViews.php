<?php
defined( 'ABSPATH' ) || exit();

class ShowPostViews {
	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'show_top_viewed_posts_pages_admin_notice' ) );
	}

	public function show_top_viewed_posts_pages_admin_notice() {
		wp_add_dashboard_widget(
			'count_post_page_view',
			'Top 3 Most Viewed Posts and Pages',
			array( $this, 'get_top_viewed_posts_pages' ),
		);
	}

	public function get_top_viewed_posts_pages() {
		$this->show_top_post_views();
		$this->show_top_page_views();
	}

	public function show_top_post_views() {
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 3,
			'meta_key' => 'post_views',
			'orderby' => 'meta_value_num',
			'order' => 'DESC'
		);

		$query = new WP_Query( $args );


		if ( $query->have_posts() ) {
			echo '<div>';
			echo '<h2> Top 3 Most Viewed Posts </h2>';
			echo '<ul>';
			while( $query->have_posts() ) {
				$query->the_post();
				$postTitle = get_the_title();
				$postViews = get_post_meta( get_the_ID(), 'post_views', true );

				echo '<li>' . $postTitle . " : $postViews" . '</li>';
			}
			echo '</ul>';
			echo '</div>';
		}

		wp_reset_postdata();
	}

	public function show_top_page_views() {
		$args = array(
			'post_type' => 'page',
			'posts_per_page' => 3,
			'meta_key' => 'post_views',
			'orderby' => 'meta_value_num',
			'order' => 'DESC'
		);

		$query = new WP_Query($args);

		if ( $query->have_posts() ) {
			echo '<div>';
			echo '<h2> Top 3 Most Viewed Pages </h2>';
			echo '<ul>';
			while( $query->have_posts() ) {
				$query->the_post();
				$pageTitle = get_the_title();
				$pageViews = get_post_meta( get_the_ID(), 'post_views', true );

				echo '<li>' . $pageTitle . " : $pageViews" . '</li>';
			}
			echo '</ul>';
			echo '</div>';
		}

		wp_reset_postdata();
	}
}