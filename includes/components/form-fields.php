<?php
if (!defined('ABSPATH')) {
    die;
}

/*
* Render text input
*/
if (!function_exists('plx_reporting_form_input_text')) {
    function plx_reporting_form_input_text(array $args)
    {
        $value = get_option($args['name']) ? 'value="' . get_option($args['name']) .  '"' : '';
        $required = (isset($args['placeholder']) && $args['placeholder'] === true) ? $args['class'] : '';

        echo '<input id="' . $args['name'] . '" name="' . $args['name'] . '" type="text" ' . $value . ' ' .  $required . '>';

        if (isset($args['message'])) {
            echo ' <p style="display: inline-block">' . $args['message'] . '</p>';
        }
    }
}

/*
* Render checkbox input
*/
if (!function_exists('plx_reporting_form_input_checkbox')) {
    function plx_reporting_form_input_checkbox(array $args)
    {
        $checked = get_option($args['name']) ? 'checked' : '';


        echo '<input id="' . $args['name'] . '" name="' . $args['name'] . '" type="checkbox" value="1" ' . $checked .  '>';

        if (isset($args['message'])) {
            echo ' <p style="display: inline-block">' . $args['message'] . '</p>';
        }
    }
}
