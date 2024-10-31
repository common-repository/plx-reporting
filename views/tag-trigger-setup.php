<?php

  // Preparing array of Click Tag
    $ctc_tags = array();
    $ctc_array = array(
        'plx_reporting_json_mail',
        'plx_reporting_json_social',
        'plx_reporting_json_outbound',
        'plx_reporting_json_tel'
    );
    foreach( $ctc_array as $ctc ){
        $bool = get_option( $ctc );
        $name = str_replace( "plx_reporting_json_", "", $ctc );
        if($bool){
            array_push($ctc_tags, $name);
        }
    }
    $ctc_tags_size = sizeof($ctc_tags);

    // OUTPUT WPCF7 FORM TAGS

    $forms = get_option( 'plx_reporting_json_form' );
    $forms_length = sizeof($forms);

    // stripped Site_url
    $site_url_1 = preg_replace( '#^https?://#', '', get_site_url() );
    $site_url = str_replace( "www.", "", $site_url_1);