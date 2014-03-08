<?php
/* The Genesis Framework (http://studiopress.com/themes/genesis/) has
 * additional hooks that allow adding microformat classes without needing to
 * add wrapper divs.  This file adjusts the uf2 plugin to take advantage of
 * those hooks when Genesis is present.
 */

// replace some post and comment hooks
remove_filter( 'the_title', 'uf2_the_title', 99, 1 );
remove_filter( 'the_content', 'uf2_the_post', 99, 1 );
remove_filter( 'the_excerpt', 'uf2_the_excerpt', 99, 1 );
remove_filter( 'the_author', 'uf2_the_author', 99, 1 );
remove_filter( 'comment_text', 'uf2_comment_text', 99, 1 );
remove_filter( 'get_comment_author_link', 'uf2_author_link' );
remove_filter( 'comment_class', 'uf2_comment_classes' );


/**
 * Markup site title as p-name on archive pages.
 */
function uf2_genesis_attr_site_title($attr) {
  if (!is_singular()) {
    $attr['class'] .= ( $attr['class'] ? ' ' : '' ) . 'p-name';
  }
  return $attr;
}
add_filter( 'genesis_attr_site-title', 'uf2_genesis_attr_site_title' );

/**
 * Add entry permalink with microformats 2 support.  This is a little ugly
 * because we're adding a non-visible anchor tag with no text, but
 * unfortunately is necessary since Genesis doesn't consistently include a
 * permalink on individual posts.
 */
function uf2_genesis_entry_permalink() {
  echo '<a class="u-url" href="' . get_permalink() .'"></a>';
}
add_filter( 'genesis_entry_header', 'uf2_genesis_entry_permalink' );

/**
 * Adds microformats v2 support to the post title.
 */
function uf2_genesis_attr_entry_title( $attr ) {
  $attr['class'] .= ( $attr['class'] ? ' ' : '' ) . 'p-name';
  return $attr;
}
add_filter( 'genesis_attr_entry-title', 'uf2_genesis_attr_entry_title', 20 );

/**
 * Adds microformats v2 support to the post content.
 */
function uf2_genesis_attr_entry_content( $attr ) {
  $attr['class'] .= ( $attr['class'] ? ' ' : '' ) . 'e-content';
  return $attr;
}
add_filter( 'genesis_attr_entry-content', 'uf2_genesis_attr_entry_content', 20 );

/**
 * Adds microformats v2 support to the post date.
 */
function uf2_genesis_attr_entry_time( $attr ) {
  $attr['class'] .= ( $attr['class'] ? ' ' : '' ) . 'dt-published';
  return $attr;
}
add_filter( 'genesis_attr_entry-time', 'uf2_genesis_attr_entry_time', 20 );

/**
 * Adds microformats v2 support to the post author.
 */
function uf2_genesis_attr_entry_author( $attr ) {
  $attr['class'] .= ( $attr['class'] ? ' ' : '' ) . 'p-author h-card';
  return $attr;
}
add_filter( 'genesis_attr_entry-author', 'uf2_genesis_attr_entry_author', 20 );

/**
 * Adds microformats v2 support to the post author link.
 */
function uf2_genesis_attr_entry_author_link( $attr ) {
  $attr['class'] .= ( $attr['class'] ? ' ' : '' ) . 'u-url';
  return $attr;
}
add_filter( 'genesis_attr_entry-author-link', 'uf2_genesis_attr_entry_author_link', 20 );

/**
 * Adds microformats v2 support to the post author name.
 */
function uf2_genesis_attr_entry_author_name( $attr ) {
  $attr['class'] .= ( $attr['class'] ? ' ' : '' ) . 'p-name';
  return $attr;
}
add_filter( 'genesis_attr_entry-author-name', 'uf2_genesis_attr_entry_author_name', 20 );

/**
 * Adds microformat 2 classes to the array of comment classes.
 */
function uf2_genesis_attr_comment( $attr ) {
  $attr['class'] .= ( $attr['class'] ? ' ' : '' ) . 'p-comment h-entry';
  return $attr;
}
add_filter( 'genesis_attr_comment', 'uf2_genesis_attr_comment', 20 );

/**
 * Adds microformats v2 support to the comment author.
 */
function uf2_genesis_attr_comment_author( $attr ) {
  $attr['class'] .= ( $attr['class'] ? ' ' : '' ) . 'p-author h-card';
  return $attr;
}
add_filter( 'genesis_attr_comment-author', 'uf2_genesis_attr_comment_author', 20 );

