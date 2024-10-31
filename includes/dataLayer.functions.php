<?php
  // Adds Relevant GTM tags
  function plx_reporting_dataLayer(){

    $opt_dl = get_option( 'plx_reporting_setting_datapush' );
    $opt_oso = get_option( 'plx_reporting_setting_onsentok' );
    $html = '';

    if( $opt_dl || $opt_oso ){
      $html .= 'document.addEventListener("wpcf7mailsent", function(e){';
      if( $opt_dl ){
        $html .= "formDetail = e.detail; var formID = formDetail.contactFormId; dataLayer.push({ 'event': 'plx_form', 'plx_data': formID });";
      }
      if( $opt_oso ){
        $html .= get_option( 'plx_reporting_setting_wpcf7mailsent' );
      }
      $html .= "});";

      wp_enqueue_script( 'plxrep', PLX_REPORTING_PLUGIN_URL . 'js/plxreporting.js', array(), '1.0.0', false );
      wp_add_inline_script( 'plxrep', $html );
    }

  }

  add_action('wp_enqueue_scripts', 'plx_reporting_dataLayer');
