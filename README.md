# [Raymond Tec](https://raymondtec.com) Simple Plugins

## Description
This will become a combination of plugins that will add funcionality to WordPress in a way that is lightweight and simple to use.

## Current Features
* Date Customizer
  * Adds last updated date to your posts above the content
  * Gives the option to show the originally published date too
  * Allows you to control whether either or both of these dates appear on pages or posts
  * Allows you to customize the text before the last updated and originally published date
  * Allows you to set custom css for each of the date types

## Future Features
* Date Customizer
  * Enqueue the CSS styles
  * Custom date formatting
  * Custom hooking for placing updated and originally published date
    * before_post_title, after_post_title, post_end, post_after
  * Verify best security practices
    * Nonces
    * Sanitization
    * Data validation
  * Translations
* Easy 301 Redirects
  * A simple way, lightweight way to create 301 redirects for any URL
* Broken Link Checker
  * A way to check for broken links on your WordPress site
* Shortcodes
  * Post Author shortcode
    * Can link to Author page or Author Email
* Turn off Dashicons
  * Allows turning off the dashicons for non-logged in users, to speed up page load
* RSS Widget Modifications
  * Open RSS Links in new window
* More Comments!

## Version History
* 0.16
  * Fixed the Issue with the admin page display
    * Reorganized the layout
  * Added custom text and custom css for Originally Published Date
  * Added option to show Original Publish date on posts, and on pages
  * Added index.php for security compliance
  * Added .zip file to repository for easy download
* 0.15 
  * Updated plugin name and variables to reflect this change
  * Moved plugin settings to their own page, rather than in the settings menu
  * Updated dashicon
  * Added option to include the originally published date
  * Added option to customize the text preceeding the last updated date
  * Added second column for admin panel; still need to fix the layout, it's dual posting all the fields
  * Fixed the issues with registering and deregistering the options when the plugin is activated/deactivated
* 0.12-0.14
  * A bunch of minor changes and functionality improvements including adding a hook to deregister and delete the options from the database when deactivating; created this as a user selectable toggle
* 0.11 
  * Added adjustable threshold setting in admin menu
  * Allows user to select number of hours difference between creation and modification date
* 0.1 
  * Initial plugin release