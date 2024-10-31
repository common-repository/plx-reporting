<?php

if (!defined('ABSPATH')) {
    die;
}


/*
* Generate the metabox on CF7 forms
*/
add_filter('wpcf7_editor_panels', 'plx_reporting_cf7_add_metabox');

if (!function_exists('plx_reporting_cf7_add_metabox')) {
    function plx_reporting_cf7_add_metabox($panels)
    {
        $new_panel = array(
            'plx_reporting_tag_manager_panel' => array(
                'title' => __('Tag Manager', 'contact-form-7'),
                'callback' => 'plx_reporting_cf7_panel'
            )
        );

        $panels = array_merge($panels, $new_panel);

        return $panels;
    }
}


/*
* Print content for the form panel
*/
if (!function_exists('plx_reporting_cf7_panel')) {
    function plx_reporting_cf7_panel($form)
    {
        $form_type_meta = get_post_meta($form->id(), '_plx_reporting_form_type');
        $selects = array(
            'form_type' => array(
                'label' => 'Form Type',
                'value' => isset($form_type_meta[0]) ? $form_type_meta[0] : '',
                'options' => array(
                    array(
                        'label' => 'Lead',
                        'value' =>  'lead'
                    ),
                    array(
                        'label' => 'Non-Lead',
                        'value' =>  'non-lead'
                    )
                )
            )
        );
?>
        <div class="contact-form-editor-box-mail wrap">
            <h2>PLX Reporting Tag Manager Settings</h2>

            <table id="plx_reporting_cf7_form_table" class="form-table">

                <?php
                foreach ($selects as $name => $select) { ?>
                    <tr>
                        <th scope="row">
                            <label for="<?php echo $name; ?>"><?php echo $select['label']; ?></label>
                        </th>
                        <td>
                            <select name="<?php echo $name; ?>" id="<?php echo $name; ?>" style="width: 300px;" required>
                                <?php
                                foreach ($select['options'] as $index => $option) {
                                    $selected = $option['value'] === $select['value'] ? 'selected' : '';
                                    echo '<option value="' . $option['value'] . '" ' . $selected . '>' . $option['label'] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
<?php
    }
}


/*
* Update form field options on cf7 save
*/
add_action('save_post', 'plx_reporting_save_fields', 10, 3);

if (!function_exists('plx_reporting_save_fields')) {
    function plx_reporting_save_fields($post_id, $post, $update)
    {
        if ($post->post_type !== 'wpcf7_contact_form') return;

        if (!empty($_POST) || $_POST['form_type']) {
            $post_id = $_POST['post_ID'];
            $form_type = $_POST['form_type'];

            update_post_meta(
                $post->ID,
                '_plx_reporting_form_type', // meta key
                $form_type // meta value
            );
        }

        $to_notify = get_option('plx_reporting_to_notify');

        if ($to_notify && strlen($to_notify)) {
            $subject = 'Form has been updated';
            $message = $post->post_title . ' form has been updated on ' . get_site_url();
            wp_mail($to_notify, $subject, $message);
        }
    }
}
