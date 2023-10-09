<?php

// ======== BEGIN ADMIN SECTION ========
// Registers the settings and fields
function rtsimplug_simple_date_settings_init() {
register_setting('rtsimplug_lu_date_options', 'rtsimplug_lu_date_display_options');
register_setting('rtsimplug_op_date_options', 'rtsimplug_op_date_display_options');
register_setting('rtsimplug_rss_custom_options', 'rtsimplug_rss_custom_options');
register_setting('rtsimplug_dashicon_options', 'rtsimplug_dashicon_options');

// Last Updated Date Display options section and fields
add_settings_section('rtsimplug_simple_date_lu_section', 'Last Updated Date Display Options', '', 'rtsimplug_lu_date_options');
add_settings_field( // Set the amount of time elapsed in hours from original publish date to modified date to be displayed
  'threshold_hours', 
  'Threshold between Publish Date and Modified Date:', 
  'threshold_hours_callback', 
  'rtsimplug_lu_date_options', 
  'rtsimplug_simple_date_lu_section', 
  array (
    'label_for' => 'threshold_hours',
    'description' => 'How many hours between Original Publish Date and Last Updated Date? Minimum: 1'
  )
);
add_settings_field( // Set whether the last updated date appears on pages
  'display_on_pages', 
  'Display on Pages:', 
  'display_on_pages_callback', 
  'rtsimplug_lu_date_options', 
  'rtsimplug_simple_date_lu_section',
  array (
    'label_for' => 'display_on_pages',
    'description' => 'Check this box to have the last updated date appear on all pages.'

  )
);
add_settings_field( // Set whether the last updated date appears on posts
  'display_on_posts', 
  'Display on Posts:', 
  'display_on_posts_callback', 
  'rtsimplug_lu_date_options', 
  'rtsimplug_simple_date_lu_section',
  array (
    'label_for' => 'display_on_posts',
    'description' => 'Check this box to have the last updated date appear on all posts.'
  )
);
add_settings_field( // Set the text that appears before the last updated date
  'custom_text', 
  'Last Updated preceeding text:', 
  'custom_text_callback', 
  'rtsimplug_lu_date_options', 
  'rtsimplug_simple_date_lu_section',
  array (
    'label_for' => 'custom_text',
    'description' => 'This is the text that appears before the last updated date. Defaults to \"Last Updated Date \".'
  )
);
add_settings_field( // Allows setting of custom css for the last updated date
  'custom_css', 
  'Last Updated CSS:', 
  'custom_css_callback', 
  'rtsimplug_lu_date_options', 
  'rtsimplug_simple_date_lu_section',
  array (
    'label_for' => 'custom_css',
    'description' => 'Custom CSS to be applied to the last updated date'
  )
);
add_settings_field(
  'delete_options_enabled', 
  'Delete Options on Deactivation:', 
  'delete_options_checkbox_callback', 
  'rtsimplug_lu_date_options', 
  'rtsimplug_simple_date_lu_section',
  array (
    'label_for' => 'delete_options_enabled',
    'description' => 'Checking this box will delete all options in the plugin from the database upon deactivation of plugin. This is irreversible.'
  )
);

//Originally Published Display options section and fields
add_settings_section('rtsimplug_simple_date_op_section', 'Original Publish Date Display Options', '', 'rtsimplug_op_date_options');
add_settings_field( // Whether or not the original publish date displays on pages
  'op_display_on_pages', 
  'Display on Pages:', 
  'op_display_on_pages_callback', 
  'rtsimplug_op_date_options', 
  'rtsimplug_simple_date_op_section',
  array (
    'label_for' => 'op_display_on_pages',
    'description' => 'Checking this box will display the original publish date on all pages on the front end.'
  )
);
add_settings_field( // Whether or not the original publish date displays on posts
  'op_display_on_posts', 
  'Display on Posts:', 
  'op_display_on_posts_callback', 
  'rtsimplug_op_date_options', 
  'rtsimplug_simple_date_op_section',
  array(
    'label_for' => 'op_display_on_posts',
    'description' => 'Checking this box will display the original publish date on all posts on the front end.'
  )
);
add_settings_field( // Sets the text preceeding the original publish date on the front end
  'op_custom_text', 
  'Originally Published preceeding text:', 
  'op_custom_text_callback', 
  'rtsimplug_op_date_options', 
  'rtsimplug_simple_date_op_section',
  array (
    'label_for' => 'op_custom_text',
    'description' => 'This is the text that appears before the orignal publish date. Defaults to \"Originally Published on \".'
  )
);
add_settings_field( // Allows for custom setting of CSS for the original publish date
  'op_custom_css', 
  'Originally Published CSS:', 
  'op_custom_css_callback', 
  'rtsimplug_op_date_options', 
  'rtsimplug_simple_date_op_section',
  array (
    'label_for' => 'op_custom_css',
    'description' => 'Custom CSS to be applied to the original publish date'
  )
);

//RSS Widget customizer Options
add_settings_section('rtsimplug_rss_section', 'RSS Widget Customizer Options', '', 'rtsimplug_rss_custom_options');
add_settings_field( // Set whether or not the RSS Widget links open in new tab
  'rss_enable_new_tab',
  'RSS Links Open in New Tab',
  'rtsimplug_rss_new_tab_callback',
  'rtsimplug_rss_custom_options',
  'rtsimplug_rss_section',
  array(
    'label_for' => 'rss_enable_new_tab',
    'description' => 'Checking this box will make all instances of the RSS widget open links in new tab; adds a tiny bit of javascript to the footer'
  )
);

// Dashicon Options section and fields
add_settings_section('rtsimplug_dashicon_section', 'Last Updated Date Display Options', '', 'rtsimplug_dashicon_options');
add_settings_field( // Set the amount of time elapsed in hours from original publish date to modified date to be displayed
  'dashicon_on_off', 
  'Turn off dashicons for guests:', 
  'rtsimplug_dashicon_callback', 
  'rtsimplug_dashicon_options', 
  'rtsimplug_dashicon_section', 
  array (
    'label_for' => 'dashicon_on_of',
    'description' => 'Loading the dashicons is unnecessary for non-logged in users and can slow pagespeed. Check the box to turn off dashicons for guests.'
  )
);
}

// ======== BEGIN ADMIN SECTION SETUP AND FORMATTING ========
//Sets the the menu page options
function rtsimplug_simple_plugin_menu() {
  add_menu_page(
      'Raymond Tec Simple Plugin Settings', // Page title
      'RT Simple', // Menu title
      'manage_options', // Capability required to access the menu
      'rtsimplug-simple-settings', // Menu slug (unique identifier)
      'rtsimplug_simple_settings_page', // Callback function to display the menu page content
      'dashicons-screenoptions' // Icon URL or Dashicons class
  );
}

// Admin Page layout - HTML and PHP Set here
function rtsimplug_simple_settings_page() {
  echo '<div class="wrap">';
  echo '<h2>Raymond Tec Simple Plugin Settings</h2>';

  // Add your settings form or content here
  ?>
  <div class="rtsimplug-simple-columns-wrapper">
      <div class="rtsimplug-simple-column">
        <form method="post" action="options.php">
          <?php 
            settings_fields('rtsimplug_lu_date_options');
            do_settings_sections('rtsimplug_lu_date_options');
          ?>
          <input type="submit" class="button-primary" value="Save Changes">
        </form>
      </div>
      <div class="rtsimplug-simple-column">
        <form method="post" action="options.php">
          <?php 
            settings_fields('rtsimplug_op_date_options');
            do_settings_sections('rtsimplug_op_date_options') 
          ?>
          <input type="submit" class="button-primary" value="Save Changes">
        </form>
      </div>
  </div>
  <div class="rtsimplug-simple-columns-wrapper">
    <div class="rtsimplug-simple-column">
      <form method="post" action="options.php">
        <?php
          settings_fields('rtsimplug_rss_custom_options');
          do_settings_sections('rtsimplug_rss_custom_options');
        ?>
        <p>Controls behavior of Automattic RSS Gutenberg Widget, <strong>site-wide</strong></p>
        <input type="submit" class="button-primary" value="Save Changes">
      </form>
    </div>
    <div class="rtsimplug-simple-column">
      <form method="post" action="options.php">
        <?php
          settings_fields('rtsimplug_dashicon_options');
          do_settings_sections('rtsimplug_dashicon_options');
        ?>
        <p>Turning this on can help improve Pagespeed</p>
        <input type="submit" class="button-primary" value="Save Changes">
      </form>
    </div>
  </div>
  <?php
  echo '</div>';
  // Add inline styles to create two columns with borders and space
  echo '<style>
          .rtsimplug-simple-columns-wrapper {
            display: flex;
            justify-content: space-between;
          }
          .rtsimplug-simple-column {
            flex-basis: 48%; /* Adjust the width as needed */
            border: 1px solid #ccc; /* Border color and thickness */
            padding: 10px; /* Add padding inside the columns */
            margin: 10px; /* Add space between the columns */
          }
        </style>';
}

add_action('admin_menu', 'rtsimplug_simple_plugin_menu');

add_action('admin_init', 'rtsimplug_simple_date_settings_init');

// ======== BEGIN ADMIN INPUT SETTINGS FUNCTIONS AND FORMATTING ========
// ======== LAST UPDATED DATE SECTION ========

//Allows setting of the interval
function threshold_hours_callback($args) {
  $options = get_option('rtsimplug_lu_date_display_options');
  $description = $args['description'];
  $default_value = 12; // Default threshold value in hours
  $threshold_hours = isset($options['threshold_hours']) ? intval($options['threshold_hours']) : $default_value;
  echo '<input type="number" id="threshold_hours" name="rtsimplug_lu_date_display_options[threshold_hours]" value="' . $threshold_hours . '"required autofocus 
    aria-required="true"
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

//Whether or not to display on pages
function display_on_pages_callback($args) {
  $options = get_option('rtsimplug_lu_date_display_options');
  $description = $args['description'];
  echo '<input type="checkbox" id="display_on_pages" name="rtsimplug_lu_date_display_options[display_on_pages]" value="1" ' . checked(1, $options['display_on_pages'], false) . ' 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

//Whether or not to display on posts
function display_on_posts_callback($args) {
  $options = get_option('rtsimplug_lu_date_display_options');
  $description = $args['description'];
  echo '<input type="checkbox" id="display_on_posts" name="rtsimplug_lu_date_display_options[display_on_posts]" value="1" ' . checked(1, $options['display_on_posts'], false) . ' 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

// Callback function for the custom text field
function custom_text_callback($args) {
  $options = get_option('rtsimplug_lu_date_display_options');
  $description = $args['description'];
  $custom_text = isset($options['custom_text']) ? esc_attr($options['custom_text']) : '';
  echo '<input type="text" id="custom_text" name="rtsimplug_lu_date_display_options[custom_text]" value="' . $custom_text . '" 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

//Adds custom CSS styling
function custom_css_callback($args) {
  $options = get_option('rtsimplug_lu_date_display_options');
  $description = $args['description'];
  $custom_css = isset($options['custom_css']) ? esc_attr($options['custom_css']) : '';
  echo '<textarea id="custom_css" name="rtsimplug_lu_date_display_options[custom_css]" rows="4" cols="50"
    aria-label="' . $description .'"
    title="' . $description .'"
  >' . esc_textarea($custom_css) . '</textarea>';
}

//Adds the option to delete the plugin's settings upon deletion
function delete_options_checkbox_callback($args) {
  $options = get_option('rtsimplug_lu_date_display_options');
  $description = $args['description'];
  $delete_options_enabled = isset($options['delete_options_enabled']) ? $options['delete_options_enabled'] : 0;
  echo '<input type="checkbox" id="delete_options_enabled" name="rtsimplug_lu_date_display_options[delete_options_enabled]" value="1" ' . checked(1, $delete_options_enabled, false) . ' 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

// ======== ORIGINALLY PUBLISHED DATE SECTION ========

// Whether or not to display on Pages
function op_display_on_pages_callback($args) {
  $options = get_option('rtsimplug_op_date_display_options');
  $description = $args['description'];
  echo '<input type="checkbox" id="op_display_on_pages" name="rtsimplug_op_date_display_options[op_display_on_pages]" value="1" ' . checked(1, $options['op_display_on_pages'], false) . ' 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

//Whether or not to display on posts
function op_display_on_posts_callback($args) {
  $options = get_option('rtsimplug_op_date_display_options');
  $description = $args['description'];
  echo '<input type="checkbox" id="op_display_on_posts" name="rtsimplug_op_date_display_options[op_display_on_posts]" value="1" ' . checked(1, $options['op_display_on_posts'], false) . ' 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

// Callback function for the custom text field
function op_custom_text_callback($args) {
  $options = get_option('rtsimplug_op_date_display_options');
  $description = $args['description'];
  $op_custom_text = isset($options['op_custom_text']) ? esc_attr($options['op_custom_text']) : '';
  echo '<input type="text" id="op_custom_text" name="rtsimplug_op_date_display_options[op_custom_text]" value="' . $op_custom_text . '" 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

//Adds custom CSS styling
function op_custom_css_callback($args) {
  $options = get_option('rtsimplug_op_date_display_options');
  $description = $args['description'];
  $op_custom_css = isset($options['op_custom_css']) ? esc_attr($options['op_custom_css']) : '';
  echo '<textarea id="op_custom_css" name="rtsimplug_op_date_display_options[op_custom_css]" rows="4" cols="50"
    aria-label="' . $description .'"
    title="' . $description .'"
  >' . esc_textarea($op_custom_css) . '</textarea>';
}

// ======== RSS Widget Customization SECTION ========
// Whether or not RSS feed links from Automattic should open in a new tab
function rtsimplug_rss_new_tab_callback($args) {
  $options = get_option('rtsimplug_rss_custom_options');
  $description = $args['description'];
  echo '<input type="checkbox" id="rss_enable_new_tab" name="rtsimplug_rss_custom_options[rss_enable_new_tab]" value="1" ' . checked(1, $options['rss_enable_new_tab'], false) . ' 
    aria-label="' . $description .'"
    title="' . $description .'"
  />';
}

// ======== Dashicon On/Off SECTION ========
// Whether or not to display the dashicons to logged in users
function rtsimplug_dashicon_callback($args) {
    $options = get_option('rtsimplug_dashicon_options');
    $description = $args['description'];
    echo '<input type="checkbox" id="dashicon_on_off" name="rtsimplug_dashicon_options[dashicon_on_off]" value="1" ' . checked(1, $options['dashicon_on_off'], false) . ' 
      aria-label="' . $description .'"
      title="' . $description .'"
    />';
  }
  