<?php
// ======== BEGIN CODE TO OUTPUT THE DATES ========
// The code to insert the last updated date.
function show_rtsimplug_simple_date( $content ) {
  $options = get_option('rtsimplug_lu_date_display_options');  // Pull the last updated date options
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
          $custom_content .= '<div class="rtsimplug-last-updated-date" style="'. esc_attr($options['custom_css']) .'">' . esc_html($custom_text) . ' ' . $updated_date . ' at ' . $updated_time . '</div>';
      }
  }

  $options = get_option('rtsimplug_op_date_display_options'); // Pull the original publishing date options
  $op_custom_text = isset($options['op_custom_text']) ? esc_html($options['op_custom_text']) : 'Originally Published on ';

  if ((is_single() && $options['op_display_on_posts']) || (is_page() && $options['op_display_on_pages'])) {

    $publish_date = get_the_time('F jS, Y', null, null, false);
    $publish_time = get_the_time('h:i a', null, null, false);
    $custom_content .= '<div class="rtsimplug-original-publish-date" style="'. esc_attr($options['op_custom_css']) .'">' . esc_html($op_custom_text) . ' ' . $publish_date . ' at ' . $publish_time . '</div>';

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
function rtsimplug_rss_customization_script() {
  $options = get_option('rtsimplug_rss_custom_options');
  if ($options['rss_enable_new_tab']) {
    wp_enqueue_script('rss-customizer', RTSIMPLUG_PLUGIN_URL . 'scripts/rss-customizer.js');
  }
}

// ======== BEGIN CODE TO TURN OFF DASHICONS ========
function rtsimplug_dashicons_off() {
  $options = get_option('rtsimplug_dashicon_options');
  if ( ! is_user_logged_in() && $options['dashicon_on_off']) {
    wp_dequeue_style('dashicons');
    wp_deregister_style( 'dashicons' );
  }
}  