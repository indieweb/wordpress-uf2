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
		add_filter( 'get_comment_author_link', array( $this, 'get_comment_author_link' ), 10, 2 );
		add_filter( 'comment_text', array( $this, 'comment_text' ), 99, 1 );
	}

	/**
	 * Adds custom classes to the array of comment classes.
	 */
	public static function comment_classes( $classes ) {
		$classes[] = 'u-comment';
		$classes[] = 'h-cite';

		return array_unique( $classes );
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
         * Adds microformats v2 support to the comment_author_link.
         */
        public static function get_comment_author_link( $return, $author, $comment_ID ) {
		$comment = get_comment( $comment_ID );
		$url     = get_comment_author_url( $comment );
                // Adds a class for microformats v2
		if ( empty( $url ) || 'http://' === $url ) {
        		return = $author;
		} else {
        		return "<a href='$url' rel='external nofollow' class='url u-url'>$author</a>";
		}
        	return $return;
	}


}
