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

defined( 'ABSPATH' ) || exit();

class CountPostPageView {
	public function __construct() {
		$this->define_constants();

		require_once( CPPV_PATH . 'src/Admin/CountPostView.php' );
		new CountPostView();

		require_once( CPPV_PATH . 'src/Admin/ShowPostViews.php' );
		new ShowPostViews();

		require_once( CPPV_PATH . 'src/Admin/AddMetaBoxPostsPages.php' );
		new AddMetaBoxPostsPages();

		require_once( CPPV_PATH . 'src/CustomLikeButton.php' );
		new CustomLikeButton();

		require_once( CPPV_PATH . 'src/Admin/CustomColumns.php' );
		new CustomColumns();
	}

	public function define_constants() {
		define( 'CPPV_PATH', plugin_dir_path( __FILE__ ) );
		define( 'CPPV_URL', plugin_dir_url( __FILE__ ) );
	}
}

 new CountPostPageView();