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
      'custom_css' => '',
      'display_on_pages' => 1,
      'display_on_posts' => 1,
      'custom_text' => 'Last Updated on ', // Add default custom text option
      'display_original_publish_date' => 1
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
}

register_activation_hook(__FILE__, 'rt_simple_plugin_activation');


//Registers the settings and fields
function rt_simple_date_settings_init() {
register_setting('rt_simple_options', 'rt_simple_date_display_options');

add_settings_section('rt_simple_date_main_section', 'Date Display Options', '', 'rt_simple_options');
add_settings_field('threshold_hours', 'Threshold (in hours)', 'threshold_hours_callback', 'rt_simple_options', 'rt_simple_date_main_section');
add_settings_field('display_on_pages', 'Display on Pages', 'display_on_pages_callback', 'rt_simple_options', 'rt_simple_date_main_section');
add_settings_field('display_on_posts', 'Display on Posts', 'display_on_posts_callback', 'rt_simple_options', 'rt_simple_date_main_section');
add_settings_field('custom_css', 'Custom CSS', 'custom_css_callback', 'rt_simple_options', 'rt_simple_date_main_section');
add_settings_field('delete_options_enabled', 'Delete Options on Deactivation', 'delete_options_checkbox_callback', 'rt_simple_options', 'rt_simple_date_main_section');
add_settings_field('custom_text', 'Custom Text for "Last Updated On"', 'custom_text_callback', 'rt_simple_options', 'rt_simple_date_main_section');
add_settings_field('display_original_publish_date', 'Display Original Publish Date', 'display_original_publish_date_callback', 'rt_simple_options', 'rt_simple_date_main_section');
}

// ======== BEGIN ADMIN SECTION SETUP AND FORMATTING ========
//Sets the the menu page options
function rt_simple_plugin_menu() {
  add_menu_page(
      'Raymond Tec Simple Plugin Settings', // Page title
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
  <div class="rt-simple-columns-wrapper">
      <div class="rt-simple-column">
          <form method="post" action="options.php">
              <?php settings_fields('rt_simple_options'); ?>
              <?php do_settings_sections('rt_simple_options'); ?>
              <input type="submit" class="button-primary" value="Save Changes">
          </form>
      </div>
      <div class="rt-simple-column">
          <h3>Additional Settings</h3>
          <?php
          // Render only the "Display Original Publish Date" option
          settings_fields('rt_simple_options');
          do_settings_fields('rt_simple_options', 'rt_simple_date_main_section');
          ?>
      </div>
  </div>
  <?php
  echo '</div>';
  // Add inline styles to create two columns with borders and space
  echo '<style>
          .rt-simple-columns-wrapper {
              display: flex;
              justify-content: space-between;
          }
          .rt-simple-column {
              flex-basis: 48%; /* Adjust the width as needed */
              border: 1px solid #ccc; /* Border color and thickness */
              padding: 10px; /* Add padding inside the columns */
              margin: 10px; /* Add space between the columns */
          }
        </style>';
}

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

// Callback function for displaying original publish date field
function display_original_publish_date_callback() {
  $options = get_option('rt_simple_date_display_options');
  echo '<input type="checkbox" id="display_original_publish_date" name="rt_simple_date_display_options[display_original_publish_date]" value="1" ' . checked(1, $options['display_original_publish_date'], false) . ' />';
}

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

// Callback function for the custom text field
function custom_text_callback() {
  $options = get_option('rt_simple_date_display_options');
  $custom_text = isset($options['custom_text']) ? esc_attr($options['custom_text']) : '';

  echo '<input type="text" id="custom_text" name="rt_simple_date_display_options[custom_text]" value="' . $custom_text . '" />';
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
  $custom_text = isset($options['custom_text']) ? esc_html($options['custom_text']) : 'Last Updated on ';
  $display_original_publish_date = isset($options['display_original_publish_date']) ? intval($options['display_original_publish_date']) : 0;

  // Check if the current content being filtered is a single post or page
  if ((is_single() && $options['display_on_posts']) || (is_page() && $options['display_on_pages'])) {
      $u_time = get_the_time('U');
      $u_modified_time = get_the_modified_time('U');
      $u_publish_time = get_the_time('U');
      $custom_content = '';

      if ($u_modified_time >= $u_time + ($threshold_hours * 3600)) {
          $updated_date = get_the_modified_time('F jS, Y');
          $updated_time = get_the_modified_time('h:i a');
          $custom_content .= '<div class="last-updated-date" style="'. esc_attr($options['custom_css']) .'">' . esc_html($custom_text) . ' ' . $updated_date . ' at ' . $updated_time . '</div>';
      }

      // Display original publish date if the option is checked
      if ($display_original_publish_date) {
          $publish_date = get_the_time('F jS, Y', null, null, false);
          $publish_time = get_the_time('h:i a', null, null, false);
          $custom_content .= '<div class="original-publish-date" style="'. esc_attr($options['custom_css']) .'">Originally Published on ' . $publish_date . ' at ' . $publish_time . '</div>';
      }

      $custom_content .= $content;
      return $custom_content;
  } else {
      // If the current content is not a single post or page, return the original content unchanged
      return $content;
  }
}

add_filter( 'the_content', 'show_rt_simple_date' );
