<?php

  // Callback for dataLayer Injection field
  function plx_reporting_setcall_json_form( $args ){
    
    $options = ( gettype( get_option( 'plx_reporting_json_form' ) ) !== "array" ) ? array() : get_option( 'plx_reporting_json_form' );
    ?>
    
    <?php echo '<style>.'.esc_attr( $args['class'] ).' option:checked {background:#0085ba;color:#fff;} option{border:1px solid #fff;}</style>';?>
    
    <select multiple multiple="multiple" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="<?php echo esc_attr( $args['label_for'] ); ?>[]" class="<?php echo esc_attr( $args['class'] ); ?>" style="width: 400px;max-width:80%;">
      <?php 
        // WP Query this thing
        $args = array(
          'post_type' => 'wpcf7_contact_form',
          'order' => 'ASC',
          'posts_per_page' => -1
        );
        $query = new WP_Query($args);
        $i = 0;
        while( $query->have_posts() ): $query->the_post(); ?>

          <option value="<?php echo get_the_id();?>" <?php echo ( in_array(get_the_id(), $options) ) ? 'selected' : ''; ?>>
            <?php echo get_the_title();?>
          </option>
          
        <?php $i++; ?>
      <?php endwhile;

        wp_reset_postdata();
  }

  // Initialise Settings
  add_action('admin_init', 'plx_reporting_init_settings');
  function plx_reporting_init_settings() {

    /*****************/
    /****   TOP   ****/
    /*****************/

    // Register
    register_setting( 'plx-reporting', 'plx_reporting_setting_GTMID' );
    register_setting( 'plx-reporting', 'plx_reporting_setting_ACCID' );
    register_setting( 'plx-reporting', 'plx_reporting_setting_GAID' );
    register_setting( 'plx-reporting', 'plx_reporting_setting_inj' );
    register_setting( 'plx-reporting', 'plx_reporting_setting_datapush' );
    register_setting( 'plx-reporting', 'plx_reporting_setting_onsentok' );
    register_setting( 'plx-reporting', 'plx_reporting_setting_wpcf7mailsent' );

    // Register Settings Section
    add_settings_section(
      'plx_reporting_set_sec_credentials',
      'Admin Credentials',
      'plx_reporting_setcall_credentials',
      'plx-reporting'
    );

    // GTM ID Setting  
    add_settings_field(
      'plx_reporting_setting_GTMID',
      'Google Tag Manager ID*',
      'plx_reporting_setcall_text',
      'plx-reporting',
      'plx_reporting_set_sec_credentials',
      [
        'label_for' => 'plx_reporting_setting_GTMID',
        'class' => 'plx_reporting_field_row',
        'type' => 'text',
        'required' => true
      ]
    );

    // GTM ACC ID Setting  
    add_settings_field(
      'plx_reporting_setting_ACCID',
      'GTM Account ID*',
      'plx_reporting_setcall_text',
      'plx-reporting',
      'plx_reporting_set_sec_credentials',
      [
        'label_for' => 'plx_reporting_setting_ACCID',
        'class' => 'plx_reporting_field_row',
        'type' => 'text',
        'required' => true
      ]
    );

    // Google Analytics ID
    add_settings_field(
      'plx_reporting_setting_GAID',
      'Google Analytics ID',
      'plx_reporting_setcall_text',
      'plx-reporting',
      'plx_reporting_set_sec_credentials',
      [
        'label_for' => 'plx_reporting_setting_GAID',
        'class' => 'plx_reporting_field_row',
        'type' => 'text'
      ]
    );
    
    // GTM Injection Setting  
    add_settings_field(
      'plx_reporting_setting_inj',
      'Add Header GTM Code',
      'plx_reporting_setcall_checkbox',
      'plx-reporting',
      'plx_reporting_set_sec_credentials',
      [
        'label_for' => 'plx_reporting_setting_inj',
        'class' => 'plx_reporting_field_row',
        'type' => 'checkbox'
      ]
    );
    
    // dataLayer Push Setting
    add_settings_field(
      'plx_reporting_setting_datapush',
      'Add WPCF7 dataLayer Code',
      'plx_reporting_setcall_checkbox',
      'plx-reporting',
      'plx_reporting_set_sec_credentials',
      [
        'label_for' => 'plx_reporting_setting_datapush',
        'class' => 'plx_reporting_field_row',
        'type' => 'checkbox'
      ]
    );
    
    // Replacement wpcf7mailsent Setting
    add_settings_field(
      'plx_reporting_setting_onsentok',
      'Add On Sent OK replacement Code',
      'plx_reporting_setcall_checkbox',
      'plx-reporting',
      'plx_reporting_set_sec_credentials',
      [
        'label_for' => 'plx_reporting_setting_onsentok',
        'class' => 'plx_reporting_field_row',
        'type' => 'checkbox'
      ]
    );
    
    // Replacement wpcf7mailsent Setting
    add_settings_field(
      'plx_reporting_setting_wpcf7mailsent',
      'Custom ON SENT javascript',
      'plx_reporting_setcall_textarea',
      'plx-reporting',
      'plx_reporting_set_sec_credentials',
      [
        'label_for' => 'plx_reporting_setting_wpcf7mailsent',
        'class' => 'plx_reporting_field_row',
        'type' => 'textarea'
      ]
    );

    // JSON Settings
    add_settings_section(
      'plx_reporting_set_sec_json',
      'JSON Export Settings',
      'plx_reporting_setcall_json',
      'plx-reporting-json'
    );


    /******************/
    /****   JSON   ****/
    /******************/

    // Register the setting
    register_setting( 'plx-reporting-json', 'plx_reporting_json_GAID' );
    register_setting( 'plx-reporting-json', 'plx_reporting_json_form' );
    register_setting( 'plx-reporting-json', 'plx_reporting_json_PLXDATA' );
    register_setting( 'plx-reporting-json', 'plx_reporting_json_BIV' );
    register_setting( 'plx-reporting-json', 'plx_reporting_json_tel' );
    register_setting( 'plx-reporting-json', 'plx_reporting_json_mail' );
    register_setting( 'plx-reporting-json', 'plx_reporting_json_pageview' );
  //  register_setting( 'plx-reporting-json', 'plx_reporting_json_social' );
    register_setting( 'plx-reporting-json', 'plx_reporting_json_outbound' );
    
    // dataLayer Push Setting
    add_settings_field(
      'plx_reporting_json_form',
      'Include '.get_the_title().' Form',
      'plx_reporting_setcall_json_form',
      'plx-reporting-json',
      'plx_reporting_set_sec_json',
      [
        'label_for' => 'plx_reporting_json_form',
        'class' => 'plx_reporting_field_row',
        'type' => 'checkbox'
      ]
    );

    // Google Analytics ID
    add_settings_field(
      'plx_reporting_json_GAID',
      'Include Google Analytics Const',
      'plx_reporting_setcall_json_GAID',
      'plx-reporting-json',
      'plx_reporting_set_sec_json',
      [
        'label_for' => 'plx_reporting_json_GAID',
        'class' => 'plx_reporting_field_row',
        'type' => 'checkbox'
      ]
    );
    
    // PLX_DATA dataLayer variable
    add_settings_field(
      'plx_reporting_json_PLXDATA',
      'Include Custom DataLater Variable',
      'plx_reporting_setcall_checkbox',
      'plx-reporting-json',
      'plx_reporting_set_sec_json',
      [
        'label_for' => 'plx_reporting_json_PLXDATA',
        'class' => 'plx_reporting_field_row',
        'type' => 'checkbox'
      ]
    );
    
    // Built In Variables variable
    add_settings_field(
      'plx_reporting_json_BIV',
      'Include All Standard Built in Variables',
      'plx_reporting_setcall_checkbox',
      'plx-reporting-json',
      'plx_reporting_set_sec_json',
      [
        'label_for' => 'plx_reporting_json_BIV',
        'class' => 'plx_reporting_field_row',
        'type' => 'checkbox'
      ]
    );
    
    // Telephone
    add_settings_field(
      'plx_reporting_json_tel',
      'Include Generic Click to Call',
      'plx_reporting_setcall_checkbox',
      'plx-reporting-json',
      'plx_reporting_set_sec_json',
      [
        'label_for' => 'plx_reporting_json_tel',
        'class' => 'plx_reporting_field_row',
        'type' => 'checkbox'
      ]
    );
    
    // Outbound Links
    add_settings_field(
      'plx_reporting_json_outbound',
      'Include Outbound Link Click',
      'plx_reporting_setcall_checkbox',
      'plx-reporting-json',
      'plx_reporting_set_sec_json',
      [
        'label_for' => 'plx_reporting_json_outbound',
        'class' => 'plx_reporting_field_row',
        'type' => 'checkbox'
      ]
    );
    
    // Social Links
    add_settings_field(
      'plx_reporting_json_mail',
      'Include Email Links Click',
      'plx_reporting_setcall_checkbox',
      'plx-reporting-json',
      'plx_reporting_set_sec_json',
      [
        'label_for' => 'plx_reporting_json_mail',
        'class' => 'plx_reporting_field_row',
        'type' => 'checkbox'
      ]
    );
    
    // Pageview
    add_settings_field(
      'plx_reporting_json_pageview',
      'Include Pageview Tag',
      'plx_reporting_setcall_checkbox',
      'plx-reporting-json',
      'plx_reporting_set_sec_json',
      [
        'label_for' => 'plx_reporting_json_pageview',
        'class' => 'plx_reporting_field_row',
        'type' => 'checkbox'
      ]
    );

  }