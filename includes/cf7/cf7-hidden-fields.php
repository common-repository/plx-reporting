<?php

if (!defined('ABSPATH')) {
    die;
}

/*
* Add hidden fields to every CF7 Form (fields data added to Data Layer)
*/
if (!function_exists('plx_reporting_cf7_add_hidden_fields')) {
    function plx_reporting_cf7_add_hidden_fields($hidden)
    {
        $form = wpcf7_get_current_contact_form();
        $form_type = get_post_meta($form->id(), '_plx_reporting_form_type');

        $hidden['_plx_reporting_form_title'] = $form->title();
        $hidden['_plx_reporting_form_type'] = count($form_type) ? $form_type[0] : 'lead';
        return $hidden;
    }
}

add_filter('wpcf7_form_hidden_fields', 'plx_reporting_cf7_add_hidden_fields');
