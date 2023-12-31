<?php
/**
 * Plugin Name:  Count Post Page View
 * Description:  This is for practice.
 * Version:      1.0.0
 * Plugin URI:   https://pluginever.com / plugins / woocommerce-new-sample / /
 * Author:       PluginEver
 * Author URI:   https://pluginever.com/
 * Text Domain:  count-post-page-view
*/

// don't call the file directly.
defined( 'ABSPATH' ) || exit();

/*
 * Class CountPostPageView
 * @since 1.0.0
 */

class CountPostPageView {

	/*
	 * CountPostPageView Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->define_constants();
		$this->require_files();
		$this->instantiate_class();
	}

	/*
	 * This function define all the constants
	 *
	 * @since 1.0.0
	 */
	public function define_constants() {
		// Define all constants
		define( 'CPPV_PATH', plugin_dir_path( __FILE__ ) );
		define( 'CPPV_URL', plugin_dir_url( __FILE__ ) );
	}

	/*
	 * Requires all file that we need to call
	 *
	 * @since 1.0.0
	 */
	public function require_files() {
		require_once( CPPV_PATH . 'src/Admin/CountPostView.php' );
		require_once( CPPV_PATH . 'src/Admin/ShowPostViews.php' );
		require_once( CPPV_PATH . 'src/Admin/AddMetaBoxPostsPages.php' );
		require_once( CPPV_PATH . 'src/CustomLikeButton.php' );
		require_once( CPPV_PATH . 'src/Admin/CustomColumns.php' );
	}

	/*
	 * It instantiates all classes
	 *
	 * @since 1.0.0
	 */
	public function instantiate_class() {
		// This class is used for increasing the value of posts and pages views
		new CountPostView();

		// This class is used for showing the 3 top most viewed pages and posts
		new ShowPostViews();

		// This class is used for adding a metabox option in both posts and pages for showing like button or not
		new AddMetaBoxPostsPages();

		// This class is used for showing like button under the title of a post and page.
		new CustomLikeButton();

		// This class is used for creating custom column to show total likes of a page and post.
		new CustomColumns();
	}
}

if ( class_exists( 'CountPostPageView' ) ) {
	// Initialize the plugin
	new CountPostPageView();
}
