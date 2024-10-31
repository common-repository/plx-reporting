<?php
if (!defined('ABSPATH')) {
    die;
}


/*
* Add Settings page to menu 
*/
add_action('admin_menu', 'plx_reporting_top_lvl_menu');

if (!function_exists('plx_reporting_top_lvl_menu')) {
    function plx_reporting_top_lvl_menu()
    {
        add_menu_page(
            'PLX Reporting Settings', // page <title>Title</title>
            'PLX Reporting', // link text
            'manage_options', // user capabilities
            'plx_reporting', // page slug
            'plx_reporting_settings_page_callback', // callback function prints the page content
            'dashicons-chart-area', // icon
        );
    }
}


/*
* prints Settings Page Content
*/
if (!function_exists('plx_reporting_settings_page_callback')) {
    function plx_reporting_settings_page_callback()
    {
        $plx_reporting_tag_manager_id = get_option('plx_reporting_tag_manager_id');
        $plx_reporting_gtm_account_id = get_option('plx_reporting_gtm_account_id');
        $plx_reporting_ga4_measurement_id = get_option('plx_reporting_ga4_measurement_id');

?>
        <div class="wrap">
            <h1><?php echo get_admin_page_title() ?></h1>
            <form method="post" action="options.php">
                <?php
                $show_GA4_json = (isset($_GET['ga4-json']) &&  $_GET['ga4-json'] === 'true');
                $show_adwords_json = (isset($_GET['ad-words-json']) &&  $_GET['ad-words-json'] === 'true');
                settings_errors('plx_reporting_settings_errors'); // errors slug
                settings_fields('plx_reporting_settings'); // settings group id
                do_settings_sections('plx_reporting'); // page slug
                echo '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">';
                if (!isset($_GET['json']) && $plx_reporting_tag_manager_id && $plx_reporting_gtm_account_id && $plx_reporting_ga4_measurement_id) {
                    echo ' <a class="button" href="?page=plx_reporting&ga4-json=true">Generate GA4 JSON</a>';
                    echo ' <a class="button" href="?page=plx_reporting&ad-words-json=true">Generate Ad Words JSON</a>';
                }
                ?>
            </form>

            <?php
            if ($show_GA4_json) {
                $json = new Ga4Json($plx_reporting_tag_manager_id, $plx_reporting_gtm_account_id, $plx_reporting_ga4_measurement_id);
                echo "<h3>Your GA4 JSON is served</h3>";
            } elseif ($show_adwords_json) {
                $json = new adWordsJson($plx_reporting_tag_manager_id, $plx_reporting_gtm_account_id, $plx_reporting_ga4_measurement_id);
                echo "<h3>Your Ad Words JSON is served</h3>";
            }

            if ($show_GA4_json || $show_adwords_json) {
                $url_arr = explode('.', str_replace(['https://', 'http://', 'www.'], '', get_site_url()));
                $filename =  $url_arr[0] . '-' . time() . '.json';
            ?>
                <p>Download the JSON and import it into your Google Tag Manager account.</p>
                <a id="plx-reporting-json-download" download="<?php echo $filename; ?>" class="button button-primary">Download JSON</a>
                <button id="plx-reporting-json-copy" class="button">Copy to clipboard</button>
                <pre id="plx-reporting-json"><?php echo $json->get_json(); ?></pre>
            <?php } ?>
        </div>
<?php
    }
}


/*
* Add settings fields 
*/
add_action('admin_init',  'plx_reporting_settings_fields');

if (!function_exists('plx_reporting_settings_fields')) {
    function plx_reporting_settings_fields()
    {
        $page_slug = 'plx_reporting';
        $option_group = 'plx_reporting_settings';
        $sections_settings_id = 'plx_reporting_settings';

        // Add Settings section
        add_settings_section(
            $sections_settings_id, // section ID
            'Admin Credentials', // section title
            function () {
                // echos any content at the top of the section
                echo '<p>Configure your reporting implementation below.</p>';
                echo '<p>Please ensure the Form Type is set within the Tag Manager tab on each of your CF7 forms.</p>';
            },
            $page_slug
        );

        // Add Tag Manager ID field
        $tag_manager_id_name = 'plx_reporting_tag_manager_id';

        register_setting($option_group, $tag_manager_id_name, 'plx_reporting_tag_id_validator');

        add_settings_field(
            $tag_manager_id_name,
            'Google Tag Manager ID*', // title
            'plx_reporting_form_input_text', // Print input callback
            $page_slug,
            $sections_settings_id,
            array(
                'name' => $tag_manager_id_name,
                'required' => true
            )
        );

        // Add GTM Account ID field
        $gtm_account_id_name = 'plx_reporting_gtm_account_id';

        register_setting($option_group, $gtm_account_id_name, 'plx_reporting_gtm_account_id_validator');

        add_settings_field(
            $gtm_account_id_name,
            'GTM Account ID*', // title
            'plx_reporting_form_input_text', // Print input callback
            $page_slug,
            $sections_settings_id,
            array(
                'name' => $gtm_account_id_name,
                'required' => true,
                'required' => true
            )
        );

        // GA4 measurement ID field
        $ga4_measurement_id_name = 'plx_reporting_ga4_measurement_id';

        register_setting($option_group, $ga4_measurement_id_name, 'ga4_measurement_id_validator');

        add_settings_field(
            $ga4_measurement_id_name,
            'GA4 Measurement ID*', // title
            'plx_reporting_form_input_text', // Print input callback
            $page_slug,
            $sections_settings_id,
            array(
                'name' => $ga4_measurement_id_name,
                'required' => true,
            )
        );

        // Emails to notify  
        $to_notify = 'plx_reporting_to_notify';

        register_setting($option_group, $to_notify, 'ga4_measurement_id_validator');

        add_settings_field(
            $to_notify,
            'To notify when forms are updated', // title
            'plx_reporting_form_input_text', // Print input callback
            $page_slug,
            $sections_settings_id,
            array(
                'name' => $to_notify,
                'required' => false,
                'message' => 'Comma-separated list of email addresses'
            )
        );

        // Add to Head & Body tickbox
        $add_header_and_body_code_name = 'plx_reporting_add_header_and_body_code';

        register_setting($option_group, $add_header_and_body_code_name, 'add_header_and_body_code_validator');

        add_settings_field(
            $add_header_and_body_code_name,
            'Add Header & Body GTM Code', // title
            'plx_reporting_form_input_checkbox', // Print input callback
            $page_slug,
            $sections_settings_id,
            array(
                'name' => $add_header_and_body_code_name,
                'message' => 'wp_body_open(); is required for this to work correctly.'
            )
        );
    }
}


/*
* Validation
*/
if (!function_exists('plx_reporting_tag_id_validator')) {
    function plx_reporting_tag_id_validator($input)
    {
        if (strlen($input) === 0) {
            add_settings_error(
                'plx_reporting_settings_errors', // slug
                'tag-manager-id-required', // part of error message ID
                'Tag Manager ID is a required field.', // message
            );

            $input = get_option('plx_reporting_tag_manager_id');
        }

        return $input;
    }
}

if (!function_exists('plx_reporting_gtm_account_id_validator')) {
    function plx_reporting_gtm_account_id_validator($input)
    {
        $errors_slug = 'plx_reporting_settings_errors';
        $current = get_option('plx_reporting_gtm_account_id');

        if (!is_string($input)) {
            add_settings_error(
                $errors_slug, // slug
                'gtm-account-id-format', // part of error message ID
                'GTM Account ID is an incorrect format.', // message
            );

            $input = $current;
        }


        if (strlen($input) === 0) {
            add_settings_error(
                $errors_slug, // slug
                'gtm-account-id-required', // part of error message ID
                'GTM Account ID is a required field.', // message
            );

            $input = $current;
        }

        return $input;
    }
}

if (!function_exists('ga4_measurement_id_validator')) {
    function ga4_measurement_id_validator($input)
    {
        $errors_slug = 'plx_reporting_settings_errors';
        $current = get_option('plx_reporting_ga4_measurement_id');

        if (!is_string($input)) {
            add_settings_error(
                $errors_slug,  // slug
                'ga4-measurement-id-format', // part of error message ID
                'GA4 Measurement ID is an incorrect format.', // message
            );

            $input = $current;
        }

        if (strlen($input) === 0) {
            add_settings_error(
                $errors_slug,  // slug
                'ga4-measurement-id-required', // part of error message ID
                'GA4 Measurement ID is a required field.', // message
            );

            $input = $current;
        }

        return $input;
    }
}

if (!function_exists('add_header_and_body_code_validator')) {
    function add_header_and_body_code_validator($input)
    {
        $errors_slug = 'plx_reporting_settings_errors';
        $current = get_option('plx_reporting_add_header_and_body_code');

        if ($input !== "1" && $input !== null) {
            add_settings_error(
                $errors_slug,
                'add_header_and_body_code-format', // part of error message ID
                'Add Header & Body is an incorrect format.', // message
            );

            $input = $current;
        }

        return $input;
    }
}


/*
* Display notice if settings saved successfully
*/
add_action('admin_notices', 'plx_reporting_settings_saved_notification');

if (!function_exists('plx_reporting_settings_saved_notification')) {
    function plx_reporting_settings_saved_notification()
    {
        $settings_errors = get_settings_errors('plx_reporting_settings_errors');

        if (!empty($settings_errors)) {
            return;
        }

        if (isset($_GET['page']) && 'plx_reporting' == $_GET['page'] && isset($_GET['settings-updated']) && true == $_GET['settings-updated']) {
            plx_reporting_success_notice('Settings have been saved successfully.');
        }
    }
}
