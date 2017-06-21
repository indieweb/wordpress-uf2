<?php
/**
 * Adds microformats2 support to your comments
 *
 */
class UF2_Comment {
	/**
	 * Initialize plugin
	 */
	public static function construct() {
		// check if theme already supports Microformats2
		if ( current_theme_supports( 'microformats2' ) ) {
			return;
		}

		add_filter( 'comment_class', array( $this, 'comment_classes' ) );
		add_filter( 'get_comment_author_link', array( $this, 'author_link' ) );
		add_filter( 'comment_text', array( $this, 'comment_text' ), 99, 1 );
	}

	/**
	 * Adds custom classes to the array of comment classes.
	 */
	public static function comment_classes( $classes ) {
		$classes[] = 'u-comment';
		$classes[] = 'h-cite';

		return $classes;
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
}
