<?php

/**
 * Adds microformats2 support to media and post formats
 *
 */
class UF2_Media {
	/**
	 * Initialize plugin
	 */
	public function __construct() {
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'wp_get_attachment_image_attributes' ), 10, 2 );
		add_filter( 'get_avatar_data', array( $this, 'get_avatar_data' ), 10, 2 );
	}

	/**
	 * Adds microformats v2 support to the get_avatar_data() method.
	 */
	public static function get_avatar_data( $args, $id_or_email ) {
			// Adds a class for microformats v2
		if ( ! isset( $args['class'] ) ) {
				$args['class'] = array();
		}

		if ( is_string( $args['class'] ) ) {
				$args['class']   = explode( ' ', $args['class'] );
				$args['class'][] = 'u-photo';
		} else {
				$args['class'][] = 'u-photo';
		}
			$args['class'] = array_unique( $args['class'] );
			return $args;
	}


	public static function wp_get_attachment_image_attributes( array $attr, WP_Post $attachment ) {
		$parents = get_post_ancestors( $attachment );
		if ( 0 == count( $parents ) ) { // For unattached images
			return $attr;
		}
		$id = $parents[ count( $parents ) - 1 ];
		if ( 'image' !== get_post_format( $id ) ) {
			return $attr;
		}
		if ( isset( $attr['class'] ) ) {
			$class         = explode( ' ', $attr['class'] );
			$class[]       = 'u-photo';
			$attr['class'] = implode( ' ', array_unique( $class ) );
		} else {
			$attr['class'] = 'u-photo';
		}
		return $attr;
	}
}
