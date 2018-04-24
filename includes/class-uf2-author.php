<?php

/**
 * Enhances Author and Avatar Markup
 *
 */
class UF2_Author {
	/**
	 * Initialize plugin
	 */
	public function __construct() {
		add_filter( 'the_author', array( $this, 'the_author' ), 99, 1 );
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
}
