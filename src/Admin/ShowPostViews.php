<?php
// don't call the file directly.
defined( 'ABSPATH' ) || exit();

/*
 * Class ShowPostViews
 *
 * @since 1.0.0
 */
class ShowPostViews {

	/*
	 * ShowPostViews Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'show_top_viewed_posts_pages_admin_notice' ) );
	}

	/*
	 * This function creates a widget in the admin dashboard
	 *
	 * @since 1.0.0
	 */
	public function show_top_viewed_posts_pages_admin_notice() {
		wp_add_dashboard_widget(
			'count_post_page_view',
			'Top 3 Most Viewed Posts and Pages',
			array( $this, 'get_top_viewed_posts_pages' ),
		);
	}

	/*
	 * This function calls the functions that shows the top 3 top most viewed pages and posts
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function get_top_viewed_posts_pages() {
		$this->show_top_post_views();
		$this->show_top_page_views();
	}

	/*
	 * Shows the 3 top most viewed posts along with their view count
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function show_top_post_views() {
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 3,
			'meta_key' => 'post_views',
			'orderby' => 'meta_value_num',
			'order' => 'DESC'
		);

		$query = new WP_Query( $args );

		// If there is any post, it gets the posts along with their view counts and displays it
		if ( $query->have_posts() ) {
			echo '<div>';
			echo '<h2> Top 3 Most Viewed Posts </h2>';
			echo '<ul>';
			while( $query->have_posts() ) {
				$query->the_post();
				$postTitle = sanitize_text_field( get_the_title() );
				$postViews = get_post_meta( get_the_ID(), 'post_views', true );

				echo '<li>' . esc_html( $postTitle ) . ' : ' . esc_html( $postViews ) . '</li>';
			}
			echo '</ul>';
			echo '</div>';
		}

		wp_reset_postdata();
	}

	/*
	 * Shows the 3 top most viewed pages along with their view count
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function show_top_page_views() {
		$args = array(
			'post_type' => 'page',
			'posts_per_page' => 3,
			'meta_key' => 'post_views',
			'orderby' => 'meta_value_num',
			'order' => 'DESC'
		);

		$query = new WP_Query($args);

		// If there is any page, it gets the pages along with their view counts and displays it
		if ( $query->have_posts() ) {
			echo '<div>';
			echo '<h2> Top 3 Most Viewed Pages </h2>';
			echo '<ul>';
			while( $query->have_posts() ) {
				$query->the_post();
				$pageTitle = sanitize_text_field( get_the_title() );
				$pageViews = get_post_meta( get_the_ID(), 'post_views', true );

				echo '<li>' . esc_html( $pageTitle ) . ' : ' . esc_html( $pageViews ) . '</li>';
			}
			echo '</ul>';
			echo '</div>';
		}

		wp_reset_postdata();
	}
}