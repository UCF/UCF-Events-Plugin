=== UCF Events Plugin ===
Contributors: ucfwebcom
Tags: ucf, events
Requires at least: 4.5.3
Requires PHP: 5.4
Tested up to: 6.1
Stable tag: 2.1.6
License: GPLv3 or later
License URI: http://www.gnu.org/copyleft/gpl-3.0.html

Provides a shortcode, widget, functions, and default styles for displaying UCF events.


== Description ==

This plugin provides a shortcode, widget, helper functions, and default styles for displaying event data from [events.ucf.edu](https://events.ucf.edu).  It is written to work out-of-the-box for non-programmers, but is also extensible and customizable for developers.


== Installation ==

= Manual Installation =
1. Upload the plugin files (unzipped) to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress
3. Configure plugin settings from the WordPress admin under "Settings > UCF Events".

= WP CLI Installation =
1. `$ wp plugin install --activate https://github.com/UCF/UCF-Events-Plugin/archive/master.zip`.  See [WP-CLI Docs](http://wp-cli.org/commands/plugin/install/) for more command options.
2. Configure plugin settings from the WordPress admin under "Settings > UCF Events".


== Changelog ==

= 2.1.6 =
Enhancements:
* Added composer file.

= 2.1.5 =
Enhancements:
* Update packages and gulpfile.js in https://github.com/UCF/UCF-Events-Plugin/pull/36
* Adjust underline styles for modern & classic layouts in https://github.com/UCF/UCF-Events-Plugin/pull/37

= 2.1.4 =
* Bug Fixes:
  * Improved compatibility with PHP 7.2 due to deprecation of `create_function()`
  * Updated Events JSON Feed URL input box to expand the full width of the screen using a built in WP class for better usability

= 2.1.3 =
* Bug Fixes:
  * Added logic to enforce a minimum value greater than 0 for feed transient expirations
  * Updated default feed URL to use HTTPS

= 2.1.2 =
* Bug Fixes:
  * Fixed display of event widget markup (the display function was not set to `echo` its results)
  * Reduced text sizes of modern layout dates + titles within widgets
* Enhancements:
  * Added http_timeout to allow timeout to be adjusted

= 2.1.1 =
* Bug Fixes:
  * Removed `is_plugin_active()` check in `ucf-events.php` and replaced with `class_exists()` check to prevent errors when `wp-admin/includes/plugin.php` is not loaded.

= 2.1.0 =
* Enhancements:
  * Added `$fallback_message` parameter to allow a no results message to be customized. Add the message by inserting it in between the opening and closing shortcodes (the content area), i.e. `[ucf-news-feed]<insert message here>[/ucf-news-feed]`.

= 2.0.1 =
* Bug Fixes:
  * Fixed notices that could occur when `UCF_Events_Feed::get_events` returns null when using the modern layout

* Enhancements:
  * Added new `modern_nodesc` layout, which is identical to the existing `modern` layout but excludes event descriptions.

= 2.0.0 =
* Enhancements:
  * Updated layout hooks to use filters instead of actions.  Please note this change is not backward-compatible with layouts registered using hooks provided by older versions of the plugin.

= 1.0.6 =
* Bug Fixes:
  * Fixed bug in modern layout that could cause broken HTML in event descriptions.

= 1.0.5 =
* Bug Fixes:
  * Fixed `display_events()` in `UCF_Events_Common` not being set as a static method
  * Updated `UCF_Events_Common::display_events()` to return its output
  * Added false-y check for `$items` in `ucf_events_display_classic()` to help prevent looping through non-items.

= 1.0.4 =
* Enhancements:
  * Added modern layout.

= 1.0.3 =
* Bug Fixes:
  * Fixed `[ucf-events]` shortcode to return its output instead of echo it; fixes output buffer issues with shortcode contents.

= 1.0.2 =
* Bug Fixes:
  * Whitelists the hostname from the default `feed_url` option to make sure `wp_safe_remote_get` does not mark calls to the host as unsafe.

= 1.0.1 =
* Bug Fixes:
  * Updated style enqueue logic to always enqueue, instead of being dependent on the widget or shortcode being on a page.
  * Corrected problem with do_action dereferencing arrays with a single index. Account for this dereference in callbacks.

= 1.0.0 =
* Initial release


== Upgrade Notice ==

n/a


== Installation Requirements ==

None


== Development & Contributing ==

NOTE: this plugin's readme.md file is automatically generated.  Please only make modifications to the readme.txt file, and make sure the `gulp readme` command has been run before committing readme changes.

= Wishlist/TODOs =
* Complete shortcode interface registration (need to complete shortcode wysiwyg interface plugin first)
