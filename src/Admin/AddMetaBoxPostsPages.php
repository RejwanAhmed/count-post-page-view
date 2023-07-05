<?php
defined( 'ABSPATH' ) || exit();

class AddMetaBoxPostsPages {
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'custom_like_button_metabox' ) );

		add_action( 'save_post', array( $this, 'custom_like_button_save_metabox' ) );
	}

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

	public function custom_like_button_metabox_callback( $post ) {
		$show_like_button = get_post_meta( $post->ID, 'show_like_button', true );
		$checked = checked( $show_like_button, '1', false );
		$escaped_checked = esc_html( $checked );

		echo '<label><input type="checkbox" name="show_like_button" value="1" ' . $escaped_checked . '> Show Like Button</label>';
	}

	public function custom_like_button_save_metabox( $post_id ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$show_like_button = isset( $_POST['show_like_button'] ) ? 1 : 0;
		$sanitized_show_like_button = sanitize_text_field( $show_like_button );
		update_post_meta( $post_id, 'show_like_button', $sanitized_show_like_button );

	}
}