# [Raymond Tec](https://raymondtec.com) Simple Plugin
## Description
This will become a combination of modifications that will add funcionality to WordPress in a way that is lightweight and simple to use.
## Current Features
### Date Customizer
* Adds last updated date to your posts above the content
* Gives the option to show the originally published date too
* Allows you to control whether either or both of these dates appear on pages or posts
* Allows you to customize the text before the last updated and originally published date
* Allows you to set custom css for each of the date types
* Defaults to on for both pages and posts for both last updated and original publish date
### RSS Widget Customizer
* Allows you to turn off and on the ability to have all Automattic RSS widgets open links in new tabs
* Defaults to on
### Turn off Dashicons
* Allows turning off the dashicons for non-logged in users, to speed up page load
* Defaults to on, which turns off dashicons for non-logged in users
## Future Features
### Date Customizer
* More Accessibility
* Enqueue the Admin CSS styles
* Add the CSS style to the customizer
* Custom date formatting
* Custom hooking for placing updated and originally published date
  * before_post_title, after_post_title, post_end, post_after
  * Allow originally published date to be placed independently of Last Updated date
* Verify best security practices
  * Nonces
  * Sanitization
  * Data validation
* Translations
* Adding exclusions to originally published and updated date
* Pull in custom post types and allow them to be turned off and on automatically
### Easy 301 Redirects - Will get its own submenu
* A simple way, lightweight way to create 301 redirects for any URL
### Broken Link Checker
* A way to check for broken links on your WordPress site
### Shortcodes
* Post Author shortcode
  * Can link to Author page or Author Email
## Version History
### 0.1.9 - 2023-10-08
  * Added option to turn off dashicons for non-logged in users to speed up pagespeed
### 0.1.8 - Not uploaded
* Updated versioning system
* Cleaned up variable and function names to comply with WP best practices - There's more to do here.
* To make it less bulky, I separated the plugin into: 
  * rt-simple: Initialization/Deinitialization/Frontend
  * rtsimplug-admin: Admin screen
* Enqueued the JavaScript for RSS customization
### 0.17 - 2023-10-08
* Accessibility
  * Added ARIA markup to all the form fields on the Admin dashboard
  * Added hover over tooltips to all the form fields on the admin dashboard
* Added autofocus to threshold hours
* Made labels clickable as well as the fields
* Removed superfluous option to turn off originally published date, as that can be controlled by turning off pages and posts together
* Added way more comments to my code (this is mostly for me)
* Add RSS Widget Modification
### 0.16 - 2023-10-07
* Fixed the Issue with the admin page display
  * Reorganized the layout
* Added custom text and custom css for Originally Published Date
* Added option to show Original Publish date on posts, and on pages
* Added index.php for security compliance
* Added .zip file to repository for easy download

### 0.15 - 2023-09-30
* GitHub repo created
* Updated plugin name and variables to reflect this change
* Moved plugin settings to their own page, rather than in the settings menu
* Updated dashicon
* Added option to include the originally published date
* Added option to customize the text preceeding the last updated date
* Added second column for admin panel; still need to fix the layout, it's dual posting all the fields
* Fixed the issues with registering and deregistering the options when the plugin is activated/deactivated

### 0.12-0.14
* A bunch of minor changes and functionality improvements including adding a hook to deregister and delete the options from the database when deactivating; created this as a user selectable toggle
### 0.11 
* Added adjustable threshold setting in admin menu
* Allows user to select number of hours difference between creation and modification date
### 0.1 
* Initial plugin created