<?php

/**
 * Plugin Name: PLX Reporting
 * Description: Speeds up Google Tag Manager integration by providing customisable and importable GTM JSON and also setting up Javascript dataLayer functions for Contact Form 7 integration.
 * Version: 2.1
 * Author: Purplex Marketing
 * License: GPL2
 */

/*
                          TM
████████╗██╗     ███╗   ███╗
██╔═══██║██║      ███╗ ███╔╝
████████║██║       ██████╔╝
██╔═════╝██║      ███╔╝███╗
██║      ███████╗███╔╝  ███╗
╚═╝      ╚══════╝╚══╝   ╚══╝
    POWER YOUR WORDPRESS
*/
if (!defined('ABSPATH')) {
  die;
}

define('PLX_REPORTING_PLUGIN', __FILE__);
define('PLX_REPORTING_PLUGIN_BASENAME', plugin_basename(PLX_REPORTING_PLUGIN));
define('PLX_REPORTING_PLUGIN_NAME', trim(dirname(PLX_REPORTING_PLUGIN_BASENAME), '/'));
define('PLX_REPORTING_PLUGIN_DIR', untrailingslashit(dirname(PLX_REPORTING_PLUGIN)));
define('PLX_REPORTING_PLUGIN_URL', untrailingslashit(plugins_url('', PLX_REPORTING_PLUGIN)));

// Re-usable components
require_once('includes/components/form-fields.php');
require_once('includes/components/notices.php');

// JSON Generator
require_once('includes/json-generator.php');

// Admin page
require_once('admin/settings.php');

// CF7
require_once('includes/cf7/cf7-tab.php');
require_once('includes/cf7/cf7-hidden-fields.php');

// JS/CSS
require_once('includes/enqueue.php');

// Add code to head and body 
require_once('includes/add-code-to-head-and-body.php');

// Install functions
register_activation_hook(__FILE__, function () {
  $query = new WP_Query(['post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1]);

  foreach ($query->posts as $index => $form) {
    if (!get_post_meta($form->ID, '_plx_reporting_form_type', true)) {
      update_post_meta($form->ID, '_plx_reporting_form_type', 'lead');
    }
  }
});
