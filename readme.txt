=== Microformats 2 ===
Contributors: pfefferle, dshanske
Tags: microformats, indieweb
Requires at least: 4.7
Tested up to: 4.8
Stable tag: 1.0.0

Enhances your WordPress theme with Microformats 2 classes.

== Description ==

It is only a very basic implementation, because not every element is accessible through actions or filters. It is better to use a theme that supports [microformats2] fully.

== Frequently Asked Questions ==

= What are Microformats 2? =

Microformats are a simple way to markup structured information in HTML. WordPress incorporates some classic Microformats. Microformats 2 supersedes class microformats.

= What does this plugin actually do? =

For all themes that do not declare support for Microformats 2, this plugin attempts to add Microformats to areas that are accessible through filters and actions.

= What can themes do to support this plugin or Microformats 2? =

The classes in this theme can optionally be called by a theme. To avoid conflict with this plugin, themes should not have CSS style any classic Microformats or
Microformats 2 classes. Most commonly, the classic Microformats class hentry.

== Changelog ==

Project actively developed on Github at [indieweb/wordpress-wp-uf2](https://github.com/indieweb/wordpress-wp-uf2). Please file support issues there.

= 1.0.0 =
* Initial Stable Release
