<?php
// don't call the file directly.
defined( 'ABSPATH' ) || exit();

/*
 * Class AddMetaBoxPostsPages
 *
 * @since 1.0.0
 */
class AddMetaBoxPostsPages {

	/*
	 * AddMetaBoxPostsPages Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Hook for creating the metabox
		add_action( 'add_meta_boxes', array( $this, 'custom_like_button_metabox' ) );

		// Hook for saving the data of metabox
		add_action( 'save_post', array( $this, 'custom_like_button_save_metabox' ) );
	}

	/*
	 * creates the metabox
	 *
	 * @since 1.0.0
	 */
	public function custom_like_button_metabox() {
		add_meta_box(
			'custom_like_button_metabox',
			'Like Button',
			array( $this, 'custom_like_button_metabox_callback' ),
			array( 'post', 'page' ),
			'side',
			'default'
		);
	}

	/*
	 * shows the show like button option which is a checkbox
	 *
	 * @since 1.0.0
	 */

	public function custom_like_button_metabox_callback( $post ) {
		$show_like_button = get_post_meta( $post->ID, 'show_like_button', true );
		$checked = checked( $show_like_button, '1', false );
		$escaped_checked = esc_html( $checked );

		echo '<label><input type="checkbox" name="show_like_button" value="1" ' . $escaped_checked . '> Show Like Button</label>';
	}

	/*
	 * It takes the value from the checkbox and  saves the value of the checkbox button as 0 or 1
	 *
	 * @since 1.0.0
	 */
	public function custom_like_button_save_metabox( $post_id ) {

		// if the user doesn't have the ability, it will not update the data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// It checks whether like button of metabox is checked or not. if checked, value will be 1 otherwise 0.

		$show_like_button = isset( $_POST['show_like_button'] ) ? 1 : 0;
		$sanitized_show_like_button = sanitize_text_field( $show_like_button );
		update_post_meta( $post_id, 'show_like_button', $sanitized_show_like_button );
	}
}