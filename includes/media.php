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
		// check if theme already supports Microformats2
		if ( current_theme_supports( 'microformats2' ) ) {
			return;
		}
	}
}
