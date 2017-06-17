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
	}

	/**
	 * Adds custom classes to the array of post classes.
	 */
	public static function post_classes( $classes ) {
		if ( ! is_singular() ) {
			return self::post_classes_helper( $classes );
		} else {
			$classes = array_diff( $classes, array( 'hentry' ) );
		}

		return $classes;
	}

	/**
	 * Adds custom classes to the array of body classes.
	 */
	public static function body_classes( $classes ) {
		if ( ! is_singular() ) {
			$classes[] = 'h-feed';
		} else {
			$classes = self::post_classes_helper( $classes );
		}

		return $classes;
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

	public static function post_classes_helper( $classes ) {
		// Adds a class for microformats v2
		$classes = array_diff( $classes, array( 'hentry' ) );
		$classes[] = 'h-entry';
		$classes[] = 'hentry';

		return $classes;
	}
}
