<?php
/*
 Plugin Name: uf2
 Plugin URI: https://github.com/pfefferle/wordpress-uf2
 Description: Adds microformats2 support to your WordPress theme
 Author: pfefferle
 Author URI: http://notizblog.org/
 Version: 1.0.0-dev
*/

add_action( 'init', array( 'Uf2Plugin', 'init' ) );

/**
 * Adds microformats2 support to your WordPress theme
 *
 * @author Matthias Pfefferle
 */
class Uf2Plugin {
	/**
	 * Initialize plugin
	 */
	public static function init() {
		// check if theme already supports Microformats2
		if ( current_theme_supports( 'microformats2' ) ) {
			return;
		}

		add_filter( 'post_class', array( 'Uf2Plugin', 'post_classes' ) );
		add_filter( 'body_class', array( 'Uf2Plugin', 'body_classes' ) );
		add_filter( 'comment_class', array( 'Uf2Plugin', 'comment_classes' ) );
		add_filter( 'get_comment_author_link', array( 'Uf2Plugin', 'author_link' ) );
		add_filter( 'get_avatar', array( 'Uf2Plugin', 'get_avatar' ) );
		add_filter( 'the_title', array( 'Uf2Plugin', 'the_title' ), 99, 1 );
		add_filter( 'the_content', array( 'Uf2Plugin', 'the_post' ), -1, 1 );
		add_filter( 'comment_text', array( 'Uf2Plugin', 'comment_text' ), 99, 1 );
		add_filter( 'the_excerpt', array( 'Uf2Plugin', 'the_excerpt' ), -1, 1 );
		add_filter( 'the_author', array( 'Uf2Plugin', 'the_author' ), 99, 1 );

		if ( function_exists( 'genesis_html5' ) && genesis_html5() ) {
			include_once dirname( __FILE__ ) . '/genesis.php';
		}
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
	 * Adds custom classes to the array of comment classes.
	 */
	public static function comment_classes( $classes ) {
		$classes[] = 'p-comment';
		$classes[] = 'h-entry';

		return $classes;
	}

	/**
	 * Adds microformats v2 support to the comment_author_link.
	 */
	public static function author_link( $link ) {
		// Adds a class for microformats v2
		return preg_replace( '/(class\s*=\s*[\"|\'])/i', '${1}u-url ', $link );
	}

	/**
	 * Adds microformats v2 support to the get_avatar() method.
	 */
	public static function get_avatar( $tag ) {
		// Adds a class for microformats v2
		return preg_replace( '/(class\s*=\s*[\"|\'])/i', '${1}u-photo ', $tag );
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
	 * Adds microformats v2 support to the comment.
	 */
	public static function comment_text( $comment ) {
		if ( ! is_admin() ) {
			return "<div class='e-content p-name p-summary'>$comment</div>";
		}

		return $comment;
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

	/**
	 * Adds microformats v2 support to the author.
	 */
	public static function the_author( $author ) {
		if ( ! is_admin() ) {
			return "<span class='p-author h-card'>$author</span>";
		}

		return $author;
	}

	public static function post_classes_helper( $classes ) {
		// Adds a class for microformats v2
		$classes = array_diff( $classes, array( 'hentry' ) );
		$classes[] = 'h-entry';
		$classes[] = 'hentry';

		// adds microformats 2 activity-stream support
		// for pages and articles
		if ( 'page' == get_post_type() ) {
			$classes[] = 'h-as-page';
		}
		if ( ! get_post_format() && 'post' == get_post_type() ) {
			$classes[] = 'h-as-article';
		}

		// adds some more microformats 2 classes based on the
		// posts "format"
		switch ( get_post_format() ) {
			case 'aside':
			case 'status':
				$classes[] = 'h-as-note';
				break;
			case 'audio':
				$classes[] = 'h-as-audio';
				break;
			case 'video':
				$classes[] = 'h-as-video';
				break;
			case 'gallery':
			case 'image':
				$classes[] = 'h-as-image';
				break;
			case 'link':
				$classes[] = 'h-as-bookmark';
				break;
		}

		return $classes;
	}
}
