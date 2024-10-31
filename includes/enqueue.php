<?php
if (!defined('ABSPATH')) {
    die;
}

/*
* Enqueue client scripts
*/
if (!function_exists('plx_reporting_client_scripts')) {
    function plx_reporting_client_scripts()
    {
        wp_enqueue_script('plx_reporting_client_script', PLX_REPORTING_PLUGIN_URL . '/public/public.js', array(), '2.0.0', true);
    }
}

add_action('wp_enqueue_scripts', 'plx_reporting_client_scripts');

/*
* Enqueue admin scripts
*/
if (!function_exists('plx_reporting_admin_scripts')) {
    function plx_reporting_admin_scripts()
    {
        wp_enqueue_style('plx_reporting_admin_styles', plugins_url('admin/admin.css', PLX_REPORTING_PLUGIN), array(), '2.0.0', 'all');
        wp_enqueue_script('plx_reporting_admin_script', PLX_REPORTING_PLUGIN_URL . '/admin/admin.js', array(), '2.0.0', true);
    }
}

add_action('admin_enqueue_scripts', 'plx_reporting_admin_scripts');
