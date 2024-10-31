<?php

  //**********************************//
  //****         Variable         ****//
  //**********************************//

    // Variable Constants
    $gaid_check = get_option( 'plx_reporting_json_GAID' );
    $gaid_text = get_option( 'plx_reporting_setting_GAID' );
    $dataLayer = get_option( 'plx_reporting_json_PLXDATA' );

  //**********************************//
  //****        Build GA ID       ****//
  //**********************************//

    // if GAID Required and has kind of correct value
    $gaid_include = ( ( strpos($gaid_text, 'UA-') !== false ) && $gaid_check );
    if( $gaid_include ):

      // Temp to push
      $temp = array();
      $temp['accountId'] = $acc_id;
      $temp['containerId'] = $con_id;
      $temp['variableId'] = "1";
      $temp['name'] = "PLX - GA ID";
      $temp['type'] = "c";
      $temp['parameter'] = array(
        parameter("TEMPLATE", "value", $gaid_text)
      );

      // Push to main TAG array
      array_push($variable, $temp);

    endif;

  //**********************************//
  //****    Build dataLayer Var   ****//
  //**********************************//

    // if Data Layer ticked
    if( $dataLayer ){

      // Temp to push
      $temp = array();
      $temp['accountId'] = $acc_id;
      $temp['containerId'] = $con_id;
      $temp['variableId'] = "2";
      $temp['name'] = "PLX - FORM ID";
      $temp['type'] = "v";
      $temp['parameter'] = array(
        parameter("INTEGER", "dataLayerVersion", "2"),
        parameter("BOOLEAN", "setDefaultValue", "false"),
        parameter("TEMPLATE", "name", "plx_data")
      );

      // Push to main TAG array
      array_push($variable, $temp);

    }


