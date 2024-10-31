<?php
if (!defined('ABSPATH')) {
    die;
}

/*
* Add head code
*/
if (!function_exists('plx_reporting_add_head_code')) {
    add_action('wp_head', 'plx_reporting_add_head_code');

    function plx_reporting_add_head_code()
    {
        $plx_reporting_tag_manager_id = get_option('plx_reporting_tag_manager_id');
        $plx_reporting_add_header_and_body_code = get_option('plx_reporting_add_header_and_body_code');

        if (!$plx_reporting_tag_manager_id || !$plx_reporting_add_header_and_body_code) {
            return;
        }
?>
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '<?php echo $plx_reporting_tag_manager_id; ?>');
        </script>
    <?php
    };
}

/*
* Add body code
*/
if (!function_exists('plx_reporting_add_body_code')) {
    function plx_reporting_add_body_code()
    {
        $plx_reporting_tag_manager_id = get_option('plx_reporting_tag_manager_id');
        $plx_reporting_add_header_and_body_code = get_option('plx_reporting_add_header_and_body_code');

        if (!$plx_reporting_tag_manager_id || !$plx_reporting_add_header_and_body_code) {
            return;
        }

    ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= $plx_reporting_tag_manager_id; ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
<?php
    };
}
add_action('wp_body_open', 'plx_reporting_add_body_code');
