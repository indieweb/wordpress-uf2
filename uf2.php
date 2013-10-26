<?php
/*
 Plugin Name: uf2
 Plugin URI: https://github.com/pfefferle/wordpress-uf2
 Description: Adds microformats2 support to your WordPress theme
 Author: pfefferle
 Author URI: http://notizblog.org/
 Version: 1.0.0-dev
*/

/**
 * Adds custom classes to the array of post classes.
 */
function uf2_post_classes( $classes ) {
  if (!is_singular()) {
    return uf2_post_classes_helper($classes);
  }

  return $classes;
}
add_filter( 'post_class', 'uf2_post_classes' );

/**
 * Adds custom classes to the array of body classes.
 */
function uf2_body_classes( $classes ) {
  if (!is_singular()) {
    $classes[] = "h-feed";
  } else {
    $classes = uf2_post_classes_helper($classes);
  }

  return $classes;
}
add_filter( 'body_class', 'uf2_body_classes' );

/**
 * Adds custom classes to the array of comment classes.
 */
function uf2_comment_classes( $classes ) {
  $classes[] = "p-comment";
  $classes[] = "h-entry";

  return $classes;
}
add_filter( 'comment_class', 'uf2_comment_classes' );

function uf2_post_classes_helper($classes) {
  // Adds a class for microformats v2
  $classes[] = 'h-entry';

  // adds microformats 2 activity-stream support
  // for pages and articles
  if ( get_post_type() == "page" ) {
    $classes[] = "h-as-page";
  }
  if ( !get_post_format() && get_post_type() == "post" ) {
    $classes[] = "h-as-article";
  }

  // adds some more microformats 2 classes based on the
  // posts "format"
  switch ( get_post_format() ) {
    case "aside":
    case "status":
      $classes[] = "h-as-note";
      break;
    case "audio":
      $classes[] = "h-as-audio";
      break;
    case "video":
      $classes[] = "h-as-video";
      break;
    case "gallery":
    case "image":
      $classes[] = "h-as-image";
      break;
    case "link":
      $classes[] = "h-as-bookmark";
      break;
  }

  return $classes;
}

/**
 * Adds microformats v2 support to the comment_author_link.
 */
function uf2_author_link( $link ) {
  // Adds a class for microformats v2
  return preg_replace('/(class\s*=\s*[\"|\'])/i', '${1}u-url ', $link);
}
add_filter( 'get_comment_author_link', 'uf2_author_link' );

/**
 * Adds microformats v2 support to the get_avatar() method.
 */
function uf2_get_avatar( $tag ) {
  // Adds a class for microformats v2
  return preg_replace('/(class\s*=\s*[\"|\'])/i', '${1}u-photo ', $tag);
}
add_filter( 'get_avatar', 'uf2_get_avatar' );

/**
 * Adds microformats v2 support to the post title.
 */
function uf2_the_title( $title ) {
  if (!is_admin() && in_the_loop()) {
    return "<span class='p-name'>$title</span>";
  }

  return $title;
}
add_filter( 'the_title', 'uf2_the_title', 99, 1 );

/**
 * Adds microformats v2 support to the post.
 */
function uf2_the_post( $post ) {
  if (!is_admin()) {
    return "<div class='e-content'>$post</div>" .
        "<div style='display: none'>\n" .
        "<a class='u-url' href='" . get_permalink() . "'>" . get_the_title() .
          "</a>\n" .
        "<time class='dt-published' datetime='" . get_the_time("c") .
          "'>" . get_the_time("r") . "</time>\n" .
        "<time class='dt-updated' datetime='" . get_the_modified_time("c") .
          "'>" . get_the_modified_time("r") . "</time>\n".
        "<span class='h-card p-author'>\n" .
          "<a class='p-name u-url' href='" . get_the_author_meta("user_url")
            . "'>" . get_the_author() . "</a>\n" .
          get_avatar(get_the_author_meta("ID")) .
        "</span>\n" .
        "</div>";
  }

  return $post;
}
add_filter( 'the_content', 'uf2_the_post', 99, 1 );

/**
 * Adds microformats v2 support to the comment.
 */
function uf2_comment_text( $comment ) {
  if (!is_admin()) {
    return "<div class='e-content'>$comment</div>\n" .
        "<div style='display: none'>\n" .
        "<a class='u-url p-name p-summary' href='" . get_comment_link() . "'>" .
          get_comment_excerpt() . "</a>\n" .
        "<time class='dt-published' datetime='" . get_comment_time("c") . "'>" .
          get_comment_time("r") . "</time>\n" .
        "</div>";
  }

  return $comment;
}
add_filter( 'comment_text', 'uf2_comment_text', 99, 1 );

/**
 * Adds microformats v2 support to the excerpt.
 */
function uf2_the_excerpt( $post ) {
  if (!is_admin()) {
    return "<div class='e-content p-summary'>$post</div>";
  }

  return $post;
}
add_filter( 'the_excerpt', 'uf2_the_excerpt', 99, 1 );
