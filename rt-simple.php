<?php
/*
Plugin Name:  Raymond Tec Simple Plugins
Description:  Date Customization for SEO and RSS Widget customizations
Version:      0.17a
Author:       Raymond Tec
Author URI:   https://raymondtec.com/
*/

// ======== BEGIN INITIALIZATION SECTION ========
// Function to initialize default plugin options
function initialize_rt_simple_plugin_options() {
  $lu_options = array( // Sets the default options upon installation for the last updated date settings
      'threshold_hours' => 12,
      'display_on_pages' => 1,
      'display_on_posts' => 1,
      'custom_text' => 'Last Updated on ',
      'custom_css' => '',
      'delete_options_enabled' => 0
  );

  $op_options = array( // Sets the default options upon installation for the original publish date settings
    'op_display_on_pages' => 1,
    'op_display_on_posts' => 1,
    'op_custom_text' => 'Originally Published on ',
    'op_custom_css' => ''
  );

  $rss_options = array( // Sets the default options for the RSS Customizer
    'rss_enable_new_tab' => 1
  );

  // Check if options already exist, if not, add the default options
  if (false === get_option('rt_lu_date_display_options')) {
    add_option('rt_lu_date_display_options', $lu_options);
  }
  if (false === get_option('rt_op_date_display_options')) {
    add_option('rt_op_date_display_options', $op_options);
  }
  if (false === get_option('rt_rss_custom_options')) {
    add_option('rt_rss_custom_options', $rss_options);
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
register_setting('rt_lu_date_options', 'rt_lu_date_display_options');
register_setting('rt_op_date_options', 'rt_op_date_display_options');
register_setting('rt_rss_custom_options', 'rt_rss_custom_options');

//Last Updated Date Display options section and fields
add_settings_section('rt_simple_date_lu_section', 'Last Updated Date Display Options', '', 'rt_lu_date_options');
add_settings_field( // Set the amount of time elapsed in hours from original publish date to modified date to be displayed
  'threshold_hours', 
  'Threshold between Publish Date and Modified Date:', 
  'threshold_hours_callback', 
  'rt_lu_date_options', 
  'rt_simple_date_lu_section', 
  array (
    'label_for' => 'threshold_hours',
    'description' => 'How many hours between Original Publish Date and Last Updated Date? Minimum: 1'
  )
);
add_settings_field( // Set whether the last updated date appears on pages
  'display_on_pages', 
  'Display on Pages:', 
  'display_on_pages_callback', 
  'rt_lu_date_options', 
  'rt_simple_date_lu_section',
  array (
    'label_for' => 'display_on_pages',
    'description' => 'Check this box to have the last updated date appear on all pages.'

  )
);
add_settings_field( // Set whether the last updated date appears on posts
  'display_on_posts', 
  'Display on Posts:', 
  'display_on_posts_callback', 
  'rt_lu_date_options', 
  'rt_simple_date_lu_section',
  array (
    'label_for' => 'display_on_posts',
    'description' => 'Check this box to have the last updated date appear on all posts.'
  )
);
add_settings_field( // Set the text that appears before the last updated date
  'custom_text', 
  'Last Updated preceeding text:', 
  'custom_text_callback', 
  'rt_lu_date_options', 
  'rt_simple_date_lu_section',
  array (
    'label_for' => 'custom_text',
    'description' => 'This is the text that appears before the last updated date. Defaults to \"Last Updated Date \".'
  )
);
add_settings_field( // Allows setting of custom css for the last updated date
  'custom_css', 
  'Last Updated CSS:', 
  'custom_css_callback', 
  'rt_lu_date_options', 
  'rt_simple_date_lu_section',
  array (
    'label_for' => 'custom_css',
    'description' => 'Custom CSS to be applied to the last updated date'
  )
);
add_settings_field(
  'delete_options_enabled', 
  'Delete Options on Deactivation:', 
  'delete_options_checkbox_callback', 
  'rt_lu_date_options', 
  'rt_simple_date_lu_section',
  array (
    'label_for' => 'delete_options_enabled',
    'description' => 'Checking this box will delete all options in the plugin from the database upon deactivation of plugin. This is irreversible.'
  )
);

//Originally Published Display options section and fields
add_settings_section('rt_simple_date_op_section', 'Original Publish Date Display Options', '', 'rt_op_date_options');
add_settings_field( // Whether or not the original publish date displays on pages
  'op_display_on_pages', 
  'Display on Pages:', 
  'op_display_on_pages_callback', 
  'rt_op_date_options', 
  'rt_simple_date_op_section',
  array (
    'label_for' => 'op_display_on_pages',
    'description' => 'Checking this box will display the original publish date on all pages on the front end.'
  )
);
add_settings_field( // Whether or not the original publish date displays on posts
  'op_display_on_posts', 
  'Display on Posts:', 
  'op_display_on_posts_callback', 
  'rt_op_date_options', 
  'rt_simple_date_op_section',
  array(
    'label_for' => 'op_display_on_posts',
    'description' => 'Checking this box will display the original publish date on all posts on the front end.'
  )
);
add_settings_field( // Sets the text preceeding the original publish date on the front end
  'op_custom_text', 
  'Originally Published preceeding text:', 
  'op_custom_text_callback', 
  'rt_op_date_options', 
  'rt_simple_date_op_section',
  array (
    'label_for' => 'op_custom_text',
    'description' => 'This is the text that appears before the orignal publish date. Defaults to \"Originally Published on \".'
  )
);
add_settings_field( // Allows for custom setting of CSS for the original publish date
  'op_custom_css', 
  'Originally Published CSS:', 
  'op_custom_css_callback', 
  'rt_op_date_options', 
  'rt_simple_date_op_section',
  array (
    'label_for' => 'op_custom_css',
    'description' => 'Custom CSS to be applied to the original publish date'
  )
);

//RSS Widget customizer Options
add_settings_section('rt_rss_section', 'RSS Widget Customizer Options', '', 'rt_rss_custom_options');
add_settings_field( // Set whether or not the RSS Widget links open in new tab
  'rss_enable_new_tab',
  'RSS Links Open in New Tab',
  'rt_rss_new_tab_callback',
  'rt_rss_custom_options',
  'rt_rss_section',
  array(
    'label_for' => 'rss_enable_new_tab',
    'description' => 'Checking this box will make all instances of the RSS widget open links in new tab; adds a tiny bit of javascript to the footer'
  )
);
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
  echo '<h2>Raymond Tec Simple Plugin Settings</h2>';

  // Add your settings form or content here
  ?>
  <div class="rt-simple-columns-wrapper">
      <div class="rt-simple-column">
        <form method="post" action="options.php">
          <?php 
            settings_fields('rt_lu_date_options');
            do_settings_sections('rt_lu_date_options');
          ?>
          <input type="submit" class="button-primary" value="Save Changes">
        </form>
      </div>
      <div class="rt-simple-column">
        <form method="post" action="options.php">
          <?php 
            settings_fields('rt_op_date_options');
            do_settings_sections('rt_op_date_options') 
          ?>
          <input type="submit" class="button-primary" value="Save Changes">
        </form>
      </div>
  </div>
  <div class="rt-simple-columns-wrapper">
    <div class="rt-simple-column">
      <p>Controls behavior of Automattic RSS Gutenberg Widget, <strong>site-wide</strong></p>
      <form method="post" action="options.php">
        <?php
          settings_fields('rt_rss_custom_options');
          do_settings_sections('rt_rss_custom_options');
        ?>
          <input type="submit" class="button-primary" value="Save Changes">
      </form>
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
          #display_on_pages {
            text-align: left;
          }
          #display_on_pages {
            text-align: left;
          }
        </style>';
}

add_action('admin_menu', 'rt_simple_plugin_menu');

add_action('admin_init', 'rt_simple_date_settings_init');

// ======== BEGIN ADMIN INPUT SETTINGS FUNCTIONS AND FORMATTING ========
// ======== LAST UPDATED DATE SECTION ========

//Allows setting of the interval
function threshold_hours_callback($args) {
  $options = get_option('rt_lu_date_display_options');
  $description = $args['description'];
  $default_value = 12; // Default threshold value in hours
  $threshold_hours = isset($options['threshold_hours']) ? intval($options['threshold_hours']) : $default_value;
  echo '<input type="number" id="threshold_hours" name="rt_lu_date_display_options[threshold_hours]" value="' . $threshold_hours . '"required autofocus 
    aria-required="true"
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

//Whether or not to display on pages
function display_on_pages_callback($args) {
  $options = get_option('rt_lu_date_display_options');
  $description = $args['description'];
  echo '<input type="checkbox" id="display_on_pages" name="rt_lu_date_display_options[display_on_pages]" value="1" ' . checked(1, $options['display_on_pages'], false) . ' 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

//Whether or not to display on posts
function display_on_posts_callback($args) {
  $options = get_option('rt_lu_date_display_options');
  $description = $args['description'];
  echo '<input type="checkbox" id="display_on_posts" name="rt_lu_date_display_options[display_on_posts]" value="1" ' . checked(1, $options['display_on_posts'], false) . ' 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

// Callback function for the custom text field
function custom_text_callback($args) {
  $options = get_option('rt_lu_date_display_options');
  $description = $args['description'];
  $custom_text = isset($options['custom_text']) ? esc_attr($options['custom_text']) : '';
  echo '<input type="text" id="custom_text" name="rt_lu_date_display_options[custom_text]" value="' . $custom_text . '" 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

//Adds custom CSS styling
function custom_css_callback($args) {
  $options = get_option('rt_lu_date_display_options');
  $description = $args['description'];
  $custom_css = isset($options['custom_css']) ? esc_attr($options['custom_css']) : '';
  echo '<textarea id="custom_css" name="rt_lu_date_display_options[custom_css]" rows="4" cols="50"
    aria-label="' . $description .'"
    title="' . $description .'"
  >' . esc_textarea($custom_css) . '</textarea>';
}

//Adds the option to delete the plugin's settings upon deletion
function delete_options_checkbox_callback($args) {
  $options = get_option('rt_lu_date_display_options');
  $description = $args['description'];
  $delete_options_enabled = isset($options['delete_options_enabled']) ? $options['delete_options_enabled'] : 0;
  echo '<input type="checkbox" id="delete_options_enabled" name="rt_lu_date_display_options[delete_options_enabled]" value="1" ' . checked(1, $delete_options_enabled, false) . ' 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

// ======== ORIGINALLY PUBLISHED DATE SECTION ========

// Whether or not to display on Pages
function op_display_on_pages_callback($args) {
  $options = get_option('rt_op_date_display_options');
  $description = $args['description'];
  echo '<input type="checkbox" id="op_display_on_pages" name="rt_op_date_display_options[op_display_on_pages]" value="1" ' . checked(1, $options['op_display_on_pages'], false) . ' 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

//Whether or not to display on posts
function op_display_on_posts_callback($args) {
  $options = get_option('rt_op_date_display_options');
  $description = $args['description'];
  echo '<input type="checkbox" id="op_display_on_posts" name="rt_op_date_display_options[op_display_on_posts]" value="1" ' . checked(1, $options['op_display_on_posts'], false) . ' 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

// Callback function for the custom text field
function op_custom_text_callback($args) {
  $options = get_option('rt_op_date_display_options');
  $description = $args['description'];
  $op_custom_text = isset($options['op_custom_text']) ? esc_attr($options['op_custom_text']) : '';
  echo '<input type="text" id="op_custom_text" name="rt_op_date_display_options[op_custom_text]" value="' . $op_custom_text . '" 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

//Adds custom CSS styling
function op_custom_css_callback($args) {
  $options = get_option('rt_op_date_display_options');
  $description = $args['description'];
  $op_custom_css = isset($options['op_custom_css']) ? esc_attr($options['op_custom_css']) : '';
  echo '<textarea id="op_custom_css" name="rt_op_date_display_options[op_custom_css]" rows="4" cols="50"
    aria-label="' . $description .'"
    title="' . $description .'"
  >' . esc_textarea($op_custom_css) . '</textarea>';
}

// ======== RSS Widget Customization SECTION ========
//Whether or not to display on pages
function rt_rss_new_tab_callback($args) {
  $options = get_option('rt_rss_custom_options');
  $description = $args['description'];
  echo '<input type="checkbox" id="rss_enable_new_tab" name="rt_rss_custom_options[rss_enable_new_tab]" value="1" ' . checked(1, $options['rss_enable_new_tab'], false) . ' 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

// ======== BEGIN DEACTIVATION FUNCTIONS ========
// Function to delete options when the plugin is deactivated or uninstalled
function rt_simple_date_deactivation() {
  $options = get_option('rt_lu_date_display_options');

  $delete_options_enabled = isset($options['delete_options_enabled']) ? $options['delete_options_enabled'] : 0;

  if ($delete_options_enabled) {
    //Clear the cache of the options
    wp_cache_delete( 'rt_lu_date_display_options', 'options' );
    wp_cache_delete( 'rt_op_date_display_options', 'options' );
    wp_cache_delete( 'rt_rss_custom_options', 'options');
    //Unregister the settings
    unregister_setting('rt_lu_date_options', 'rt_lu_date_display_options');
    unregister_setting('rt_op_date_options', 'rt_op_date_display_options');
    unregister_setting('rt_rss_custom_options', 'rt_rss_custom_options');
    //Delete the options
    delete_option('rt_lu_date_display_options');
    delete_option('rt_op_date_display_options');
    delete_option('rt_rss_custom_options');
  }
}

// Register the deactivation hook
register_deactivation_hook(__FILE__, 'rt_simple_date_deactivation');

// ======== BEGIN CODE TO OUTPUT THE ACTUAL DATES ========
// The code to insert the last updated date.
function show_rt_simple_date( $content ) {
  $options = get_option('rt_lu_date_display_options');  // Pull the last updated date options
  $threshold_hours = isset($options['threshold_hours']) ? intval($options['threshold_hours']) : 12; //Sanitize and set the variable for threshold
  $custom_text = isset($options['custom_text']) ? esc_html($options['custom_text']) : 'Last Updated on '; //Sanitize and set the variable for custom LU text
  $custom_content = ''; // Initialize the custom content variable

  // Check if the current content being filtered is a single post or page, and whether the option is turned on for last updated date
  if ((is_single() && $options['display_on_posts']) || (is_page() && $options['display_on_pages'])) {
      $u_time = get_the_time('U'); 
      $u_modified_time = get_the_modified_time('U');
  
      // Calculates the threshold time and only displays if it's above the number of hours
      if ($u_modified_time >= $u_time + ($threshold_hours * 3600)) {
          $updated_date = get_the_modified_time('F jS, Y');
          $updated_time = get_the_modified_time('h:i a');
          $custom_content .= '<div class="last-updated-date" style="'. esc_attr($options['custom_css']) .'">' . esc_html($custom_text) . ' ' . $updated_date . ' at ' . $updated_time . '</div>';
      }
  }

  $options = get_option('rt_op_date_display_options'); // Pull the original publishing date options
  $op_custom_text = isset($options['op_custom_text']) ? esc_html($options['op_custom_text']) : 'Originally Published on ';

  if ((is_single() && $options['op_display_on_posts']) || (is_page() && $options['op_display_on_pages'])) {

    $publish_date = get_the_time('F jS, Y', null, null, false);
    $publish_time = get_the_time('h:i a', null, null, false);
    $custom_content .= '<div class="original-publish-date" style="'. esc_attr($options['op_custom_css']) .'">' . esc_html($op_custom_text) . ' ' . $publish_date . ' at ' . $publish_time . '</div>';

    $custom_content .= $content;
  } else {
    $custom_content .= $content; // If original publishing date isn't used, do this.
  }

  if (!empty($custom_content)) {
    return $custom_content;
  } else {
    return $content;
  }
}

// ======== BEGIN CODE TO ADD JAVASCRIPT FOR RSS CUSTOMIZATION ========
function add_rt_rss_script_to_footer() {
  $options = get_option('rt_rss_custom_options');
  if ($options['rss_enable_new_tab']) {
  ?>
  <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function() {
          var rssLinks = document.querySelectorAll('.wp-block-rss a');
          rssLinks.forEach(function(link) {
              link.setAttribute('target', '_blank');
          });
      });
  </script>
  <?php
  }
}

add_filter( 'the_content', 'show_rt_simple_date' );
add_action('wp_footer', 'add_rt_rss_script_to_footer');