<?php
if (!defined('ABSPATH')) {
    die;
}

if (!function_exists('plx_reporting_success_notice')) {
    function plx_reporting_success_notice($message)
    {
?>
        <div class="notice notice-success is-dismissible">
            <p>
                <strong><?php echo $message; ?></strong>
            </p>
        </div>
<?php
    }
}
