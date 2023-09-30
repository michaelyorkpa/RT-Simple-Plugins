<?php
/*
Plugin Name:  Raymond Tec Simple Plugins
Description:  Shows the last updated date on posts and pages. Creates class "last-updated-date" for CSS customization. Settings in RT Simple in Admin Panel.
Version:      0.15
Author:       Raymond Tec
Author URI:   https://raymondtec.com/
*/

/* ======== LISTING OF ALL FUNCTIONS AND VARIABLES AND THEIR PURPOSES HERE ========
  ======== FUNCTIONS ========
  initialize_rt_simple_plugin_options - creates the default plugin options
  rt_simple_plugin_activation - calls the function above and registers the activation hooks
  rt_simple_date_settings_init - registers the settings and adds the settings to the options table
  rt_simple_plugin_menu - Sets the option for the admin panel page
  
*/

// ======== BEGIN INITIALIZATION SECTION ========
// Function to initialize default plugin options
function initialize_rt_simple_plugin_options() {
  $default_options = array(
      'threshold_hours' => 12,
      'delete_options_enabled' => 0,
      'custom_css' => ''
      // Add more default options if needed
  );

  // Check if options already exist, if not, add the default options
  if (false === get_option('rt_simple_date_display_options')) {
      add_option('rt_simple_date_display_options', $default_options);
  }
}

// Register activation hook
function rt_simple_plugin_activation() {
  // Initialize default plugin options
  initialize_rt_simple_plugin_options();

  // Additional activation tasks can go here if needed
  register_activation_hook(__FILE__, 'rt_simple_plugin_activation');
}


//Registers the settings and fields
function rt_simple_date_settings_init() {
register_setting('rt_simple_options', 'rt_simple_date_display_options');

add_settings_section('rt_simple_date_main_section', 'Display Options', '', 'rt_simple_options');
add_settings_field('threshold_hours', 'Threshold (in hours)', 'threshold_hours_callback', 'rt_simple_options', 'rt_simple_date_main_section');
add_settings_field('display_on_pages', 'Display on Pages', 'display_on_pages_callback', 'rt_simple_options', 'rt_simple_date_main_section');
add_settings_field('display_on_posts', 'Display on Posts', 'display_on_posts_callback', 'rt_simple_options', 'rt_simple_date_main_section');
add_settings_field('custom_css', 'Custom CSS', 'custom_css_callback', 'rt_simple_options', 'rt_simple_date_main_section');
add_settings_field('delete_options_enabled', 'Delete Options on Deactivation', 'delete_options_checkbox_callback', 'rt_simple_options', 'rt_simple_date_main_section');
}


// ======== BEGIN ADMIN SECTION SETUP AND FORMATTING ========
//Sets the the menu page options
function rt_simple_plugin_menu() {
  add_menu_page(
      'RT Simple Plugin Settings', // Page title
      'RT Simple', // Menu title
      'manage_options', // Capability required to access the menu
      'rt-simple-settings', // Menu slug (unique identifier)
      'rt_simple_settings_page', // Callback function to display the menu page content
      'dashicons-screenoptions' // Icon URL or Dashicons class
  );
}

// Admin Page layout - HTML and PHP Set here
function rt_simple_settings_page() {
  echo '<div class="wrap">';
  echo '<h2>RT Simple Plugin Settings</h2>';

  // Add your settings form or content here
  ?>
      <form method="post" action="options.php">
          <?php settings_fields('rt_simple_options'); ?>
          <?php do_settings_sections('rt_simple_options'); ?>
          <input type="submit" class="button-primary" value="Save Changes">
      </form>
  <?php  
  echo '</div>';
}

// ======== DEPRECATED CODE FOR ADDING PLUGIN TO ADMIN->SETTINGS ========
//Creates the entry in the WP -> Settings menu
/*add_action('admin_menu', function() {
  add_options_page('Last Updated Settings', 'Last Updated', 'manage_options', 'rt_simple_options', 'rt_simple_options_page');
});*/

add_action('admin_menu', 'rt_simple_plugin_menu');

add_action('admin_init', 'rt_simple_date_settings_init');

// ======== BEGIN ADMIN INPUT SETTINGS FUNCTIONS AND FORMATTING ========
//Whether or not to display on pages
function display_on_pages_callback() {
  $options = get_option('rt_simple_date_display_options');
  echo '<input type="checkbox" id="display_on_pages" name="rt_simple_date_display_options[display_on_pages]" value="1" ' . checked(1, $options['display_on_pages'], false) . ' />';
}

//Whether or not to display on posts
function display_on_posts_callback() {
  $options = get_option('rt_simple_date_display_options');
  echo '<input type="checkbox" id="display_on_posts" name="rt_simple_date_display_options[display_on_posts]" value="1" ' . checked(1, $options['display_on_posts'], false) . ' />';
}

//Allows setting of the date format
/*
function display_style() {
    $options = get_option('')
}*/

//Allows setting of the interval
function threshold_hours_callback() {
  $options = get_option('rt_simple_date_display_options');
  $default_value = 12; // Default threshold value in hours
  $threshold_hours = isset($options['threshold_hours']) ? intval($options['threshold_hours']) : $default_value;

  echo '<input type="number" id="threshold_hours" name="rt_simple_date_display_options[threshold_hours]" value="' . esc_attr($options['threshold_hours']) . '" />';
}

//Adds custom CSS styling
function custom_css_callback() {
  $options = get_option('rt_simple_date_display_options');
  $custom_css = isset($options['custom_css']) ? $options['custom_css'] : '';
  echo '<textarea id="custom_css" name="rt_simple_date_display_options[custom_css]" rows="4" cols="50">' . esc_textarea($custom_css) . '</textarea>';
}

//Adds the option to delete the plugin's settings upon deletion
function delete_options_checkbox_callback() {
  $options = get_option('rt_simple_date_display_options');
  $delete_options_enabled = isset($options['delete_options_enabled']) ? $options['delete_options_enabled'] : 0;
  echo '<input type="checkbox" id="delete_options_enabled" name="rt_simple_date_display_options[delete_options_enabled]" value="1" ' . checked(1, $delete_options_enabled, false) . ' />';
}

// Function to delete options when the plugin is deactivated or uninstalled
function rt_simple_date_deactivation() {
  $options = get_option('rt_simple_date_display_options');

  $delete_options_enabled = isset($options['delete_options_enabled']) ? $options['delete_options_enabled'] : 0;

  if ($delete_options_enabled) {
    //Clear the cache of the options
    wp_cache_delete( 'rt_simple_date_display_options', 'options' );
    //Unregister the settings
    unregister_setting('rt_simple_options', 'rt_simple_date_display_options');
    //Delete the options
    delete_option('rt_simple_date_display_options');
  }
}

// Register the deactivation hook
register_deactivation_hook(__FILE__, 'rt_simple_date_deactivation');

// The code to insert the last updated date.
function show_rt_simple_date( $content ) {
  $options = get_option('rt_simple_date_display_options');
  $threshold_hours = isset($options['threshold_hours']) ? intval($options['threshold_hours']) : 12;
  $custom_css = isset($options['custom_css']) ? wp_kses_post($options['custom_css']) : '';

  // Check if the current content being filtered is a single post
  if (is_single() && $options['display_on_posts'] || is_page() && $options['display_on_pages']) {
      $u_time = get_the_time('U');
      $u_modified_time = get_the_modified_time('U');
      $custom_content = '';

      if ($u_modified_time >= $u_time + ($threshold_hours * 3600)) {
          $updated_date = get_the_modified_time('F jS, Y');
          $updated_time = get_the_modified_time('h:i a');
          $custom_content .= '<div class="last-updated-date" style="'. $custom_css .'">Last Updated on '. $updated_date . ' at '. $updated_time .'</div>';
      }

      $custom_content .= $content;
      return $custom_content;
  } else {
      // If the current content is not a single post or page, return the original content unchanged
      return $content;
  }
}

add_filter( 'the_content', 'show_rt_simple_date' );
