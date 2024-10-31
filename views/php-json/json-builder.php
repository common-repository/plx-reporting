<?php

  //**********************************//
  //****        Constants         ****//
  //**********************************//

    // Primary JSON array
    $json = array();

  //**********************************//
  //****         FUNCTIONS        ****//
  //**********************************//

    // Function to create Variable Paramters
    function parameter($type, $key, $value){
      return array(
        "type" => $type,
        "key" => $key,
        "value" => $value
      );
    };

    // Stripped SITE URL
    $site_url_1 = preg_replace( '#^https?://#', '', get_site_url() );
    $site_url = str_replace( "www.", "", $site_url_1);

  //**********************************//
  //****      Container Keys      ****//
  //**********************************//

    // Inner Container Array
    $container = array();

    // Inner Container Key => Values
    $container['name'] = $site_url;
    $container['publicId'] = $gtm_id;
    $container['usageContext'] = array("WEB");
  
  //**********************************//
  //****       Tags/Triggers      ****//
  //**********************************//

    // tags Array
    $tag = array();
    $trigger = array();

    // The Tag Builder
    require_once('json-builder-tag_trigger.php');
  
  
  //**********************************//
  //****         Variables        ****//
  //**********************************//

    // variable Array
    $variable = array();

    // The Variable Builder
    require_once('json-builder-variable.php');
  
  //**********************************//
  //****     builtInVariables     ****//
  //**********************************//

    // builtInVariable Array
    $builtInVariable = array();
  
    // The builtInVariable Builder
    require_once('json-builder-builtInVariable.php');

  //**********************************//
  //****  Container Version Keys  ****//
  //**********************************//

    // containerVersion Array
    $containerVersion = array();
    
    // Add containerVersion Key => Values
    $containerVersion['name'] = ("PLX Export - ".get_bloginfo()." - ".date('Y-m-d'));
    $containerVersion['accountId'] = $acc_id;
    $containerVersion['containerId'] = $con_id;
    $containerVersion['container'] = $container;
    $containerVersion['tag'] = $tag;
    $containerVersion['trigger'] = $trigger;
    $containerVersion['variable'] = $variable;
    $containerVersion['builtInVariable'] = $builtInVariable;

  //**********************************//
  //****        JSON Keys         ****//
  //**********************************//

    $json['exportFormatVersion'] = 2;
    $json['exportTime'] = date('Y-m-d H:i:s');
    $json['containerVersion'] = $containerVersion;

  //**********************************//
  //****          OUTPUT          ****//
  //**********************************//

    // Echo out encoded as JSON
    echo JSON_encode($json, JSON_PRETTY_PRINT);