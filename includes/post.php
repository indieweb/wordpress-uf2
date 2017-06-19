<?php

/**
 * Adds microformats2 support to your posts
 *
 */
class UF2_Post {
	/**
	 * Initialize plugin
	 */
	public function __construct() {
		add_filter( 'post_class', array( $this, 'post_classes' ) );
		add_filter( 'body_class', array( $this, 'body_classes' ) );
		add_filter( 'the_title', array( $this, 'the_title' ), 99, 1 );
		// The priority ensures that the content and not anything added dynamically by another plugin.
		add_filter( 'the_content', array( $this, 'the_post' ), -1, 1 );
		add_filter( 'the_excerpt', array( $this, 'the_excerpt' ), -1, 1 );

		add_filter( 'date_i18n', array( $this, 'fix_c_time_format' ), 10, 3 );
	}
	
	function fix_c_time_format( $date, $format, $timestamp ) {
	    if ( 'c' == $format )
		            $date = date_i18n( DATE_W3C, $timestamp );

	        return $date;
	}

	/**
	 * Adds custom classes to the array of post classes.
	 */
	public static function post_classes( $classes ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
		if ( ! is_singular() ) {
			if ( 'page' !== get_post_type() ) {
				// Adds a class for microformats v2
				$classes[] = 'h-entry';
				// add hentry to the same tag as h-entry
				$classes[] = 'hentry';
			}
		}
		return $classes;
	}

	/**
	 * Adds custom classes to the array of body classes.
	 */
	public static function body_classes( $classes ) {
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
			$classes[] = 'h-feed';
		} else {
			if ( 'page' !== get_post_type() ) {
				$classes[] = 'hentry';
				$classes[] = 'h-entry';
			}
		}
		return array_unique( $classes );
	}

	/**
	 * Adds microformats v2 support to the post title.
	 */
	public static function the_title( $title ) {
		if ( ! is_admin() && in_the_loop() ) {
			return "<span class='p-name'>$title</span>";
		}

		return $title;
	}

	/**
	 * Adds microformats v2 support to the post.
	 */
	public static function the_post( $post ) {
		if ( ! is_admin() ) {
			return "<div class='e-content'>$post</div>";
		}

		return $post;
	}

	/**
	 * Adds microformats v2 support to the excerpt.
	 */
	public static function the_excerpt( $post ) {
		if ( ! is_admin() ) {
			return "<div class='e-content p-summary'>$post</div>";
		}

		return $post;
	}
}
