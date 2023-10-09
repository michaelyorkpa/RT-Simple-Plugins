<?php
/*
Plugin Name:        Raymond Tec Simple Plugins
Description:        Date and RSS Widget customizations, turn off dashicons
Version:            0.1.9
Requires at least:  6.3.0
Requires PHP:       7.4
Author:             Raymond Tec
Author URI:         https://raymondtec.com/
*/

define('RTSIMPLUG_PLUGIN_URL', plugin_dir_url(__FILE__));

// ======== BEGIN INITIALIZATION SECTION ========
// Function to initialize default plugin options
function initialize_rtsimplug_simple_plugin_options() {
  $rtsimplug_lu_options = array( // Sets the default options upon installation for the last updated date settings
      'threshold_hours' => 12,
      'display_on_pages' => 1,
      'display_on_posts' => 1,
      'custom_text' => 'Last Updated on ',
      'custom_css' => '',
      'delete_options_enabled' => 0
  );

  $rtsimplug_op_options = array( // Sets the default options upon installation for the original publish date settings
    'op_display_on_pages' => 1,
    'op_display_on_posts' => 1,
    'op_custom_text' => 'Originally Published on ',
    'op_custom_css' => ''
  );

  $rtsimplug_rss_options = array( // Sets the default options for the RSS Customizer
    'rss_enable_new_tab' => 1
  );

  $rtsimplug_dashicon_options = array( // Sets the default option to turn off the dashicon for non-logged in users
    'dashicon_on_off' => 1
  );

  // Check if options already exist, if not, add the default options
  if (false === get_option('rtsimplug_lu_date_display_options')) {
    add_option('rtsimplug_lu_date_display_options', $rtsimplug_lu_options);
  }
  if (false === get_option('rtsimplug_op_date_display_options')) {
    add_option('rtsimplug_op_date_display_options', $rtsimplug_op_options);
  }
  if (false === get_option('rtsimplug_rss_custom_options')) {
    add_option('rtsimplug_rss_custom_options', $rtsimplug_rss_options);
  }
  if (false === get_option('rtsimplug_dashicon_options')) {
    add_option('rtsimplug_dashicon_options', $rtsimplug_dashicon_options);
  }
}

// Register activation hook
function rtsimplug_simple_plugin_activation() {
  initialize_rtsimplug_simple_plugin_options();
}

register_activation_hook(__FILE__, 'rtsimplug_simple_plugin_activation');

if (is_admin()) { // Include the admin stuff if it's required
  require_once(plugin_dir_path(__FILE__) . 'rtsimplug-admin.php');
}

// ======== BEGIN DEACTIVATION FUNCTIONS ========
// Function to delete options when the plugin is deactivated or uninstalled
function rtsimplug_simple_date_deactivation() {
  $options = get_option('rtsimplug_lu_date_display_options');

  $delete_options_enabled = isset($options['delete_options_enabled']) ? $options['delete_options_enabled'] : 0;

  if ($delete_options_enabled) {
    //Clear the cache of the options
    wp_cache_delete( 'rtsimplug_lu_date_display_options', 'options' );
    wp_cache_delete( 'rtsimplug_op_date_display_options', 'options' );
    wp_cache_delete( 'rtsimplug_rss_custom_options', 'options');
    wp_cache_delete( 'rtsimplug_dashicon_options', 'options');
    //Unregister the settings
    unregister_setting('rtsimplug_lu_date_options', 'rtsimplug_lu_date_display_options');
    unregister_setting('rtsimplug_op_date_options', 'rtsimplug_op_date_display_options');
    unregister_setting('rtsimplug_rss_custom_options', 'rtsimplug_rss_custom_options');
    unregister_setting('rtsimplug_dashicon_options', 'rtsimplug_dashicon_options');
    //Delete the options
    delete_option('rtsimplug_lu_date_display_options');
    delete_option('rtsimplug_op_date_display_options');
    delete_option('rtsimplug_rss_custom_options');
    delete_option('rtsimplug_dashicon_options');
  }
}

// Register the deactivation hook
register_deactivation_hook(__FILE__, 'rtsimplug_simple_date_deactivation');

require_once(plugin_dir_path(__file__) . 'rtsimplug-frontend.php');

add_filter( 'the_content', 'show_rtsimplug_simple_date' );
add_action('wp_footer', 'rtsimplug_rss_customization_script');
add_action( 'wp_enqueue_scripts', 'rtsimplug_dashicons_off' );