<?php

  //**********************************//
  //****       CF7 Form Loop      ****//
  //**********************************//

    // CF7 Forms
    $forms = get_option( 'plx_reporting_json_form' );
    
    if( $forms ){
      $i = 0;
      foreach( $forms as $form ){

        // CREATE TAG
        $temp_tag = array();
        $temp_tag['tagId'] = $form;
        $temp_tag['accountId'] = $acc_id;
        $temp_tag['containerId'] = $con_id;
        $temp_tag['name'] = "CF7 - ".$form." - ".strtolower(get_the_title($form));
        $temp_tag['type'] = "ua";
        $temp_tag['parameter'] = array(
          parameter("BOOLEAN", "nonInteraction", "false"),
          parameter("BOOLEAN", "overrideGaSettings", "true"),
          parameter("TEMPLATE", "eventCategory", "PLX - CF7"),
          parameter("TEMPLATE", "trackType", "TRACK_EVENT"),
          parameter("TEMPLATE", "eventAction", "submission {{PLX - FORM ID}}"),
          parameter("TEMPLATE", "eventLabel", "{{Page URL}}"),
          parameter("TEMPLATE", "trackingId", "{{PLX - GA ID}}")
        );
        $temp_tag['firingTriggerId'] = array(
          $form
        );

        // Create Custom Event Filter
        $customEventFilter = array();
        $customEventFilter['type'] = "EQUALS";
        $customEventFilter['parameter'] = array(
          parameter("TEMPLATE", "arg0", "{{_event}}"),
          parameter("TEMPLATE", "arg1", "plx_form")
        );

        // Create Filter
        $filter = array();
        $filter['type'] = "EQUALS";
        $filter['parameter'] = array(
          parameter("TEMPLATE", "arg0", "{{PLX - FORM ID}}"),
          parameter("TEMPLATE", "arg1", $form)
        );

        // CREATE TRIGGER
        $temp_trig = array();
        $temp_trig['triggerId'] = $form;
        $temp_trig['accountId'] = $acc_id;
        $temp_trig['containerId'] = $con_id;
        $temp_trig['name'] = "CF7 - ".$form." - ".strtolower(get_the_title($form));
        $temp_trig['type'] = "CUSTOM_EVENT";
        $temp_trig['customEventFilter'] = array(
          $customEventFilter
        );
        $temp_trig['filter'] = array(
          $filter
        );

        // Push Tag and Trigger pair
        array_push($tag, $temp_tag);
        array_push($trigger, $temp_trig);
      }
    }


  //**********************************//
  //****    EMAIL CLICK PAIRS     ****//
  //**********************************//

    // Email Click
    $click_mail = get_option( 'plx_reporting_json_mail' );
    $i = 0;
    if($click_mail){

      // Mail Tag
      $temp_tag = array();
      $temp_tag['accountId'] = $acc_id;
      $temp_tag['containerId'] = $con_id;
      $temp_tag['tagId'] = 87;
      $temp_tag['name'] = "PLX - Email Click";
      $temp_tag['type'] = "ua";
      $temp_tag['tagFiringOption'] = "ONCE_PER_EVENT";
      $temp_tag['parameter'] = array(
        parameter("BOOLEAN", "nonInteraction", "false"),
        parameter("BOOLEAN", "overrideGaSettings", "true"),
        parameter("TEMPLATE", "eventCategory", "Click - Email"),
        parameter("TEMPLATE", "trackType", "TRACK_EVENT"),
        parameter("TEMPLATE", "eventAction", "{{Click URL}}"),
        parameter("TEMPLATE", "eventLabel", "{{Page URL}}"),
        parameter("TEMPLATE", "trackingId", "{{PLX - GA ID}}")
      );
      $temp_tag['firingTriggerId'] = array(
        87
      );

      // Mail Trigger Filter
      $filter = array();
      $filter['type'] = "CONTAINS";
      $filter['parameter'] = array(
        parameter("TEMPLATE", "arg0", "{{Click URL}}"),
        parameter("TEMPLATE", "arg1", "mailto:")
      );

      // Mail Trigger
      $temp_trig = array();
      $temp_trig['accountId'] = $acc_id;
      $temp_trig['containerId'] = $con_id;
      $temp_trig['triggerId'] = 87;
      $temp_trig['type'] = "LINK_CLICK";
      $temp_trig['name'] = "PLX - Email Click";
      $temp_trig['filter'] = array(
        $filter
      );
      $temp_trig['waitForTags'] = array();
      $temp_trig['waitForTags']['type'] = "BOOLEAN";
      $temp_trig['waitForTags']['value'] = "false";
      $temp_trig['checkValidation'] = array();
      $temp_trig['checkValidation']['type'] = "BOOLEAN";
      $temp_trig['checkValidation']['value'] = "false";
      $temp_trig['waitForTagsTimeout'] = array();
      $temp_trig['waitForTagsTimeout']['type'] = "TEMPLATE";
      $temp_trig['waitForTagsTimeout']['value'] = 2000;
      $temp_trig['uniqueTriggerId'] = array();
      $temp_trig['uniqueTriggerId']['type'] = "TEMPLATE";

      // Push Tag and Trigger pair
      array_push($tag, $temp_tag);
      array_push($trigger, $temp_trig);
    }


  //**********************************//
  //****     TEL CLICK PAIRS      ****//
  //**********************************//

    // Telephone Click
    $click_tel = get_option( 'plx_reporting_json_tel' );
    if($click_tel){

      // Telephone Tag
      $temp_tag = array();
      $temp_tag['accountId'] = $acc_id;
      $temp_tag['containerId'] = $con_id;
      $temp_tag['tagId'] = 88;
      $temp_tag['name'] = "PLX - Telephone Click";
      $temp_tag['type'] = "ua";
      $temp_tag['tagFiringOption'] = "ONCE_PER_EVENT";
      $temp_tag['parameter'] = array(
        parameter("BOOLEAN", "nonInteraction", "false"),
        parameter("BOOLEAN", "overrideGaSettings", "true"),
        parameter("TEMPLATE", "eventCategory", "Click - Telephone"),
        parameter("TEMPLATE", "trackType", "TRACK_EVENT"),
        parameter("TEMPLATE", "eventAction", "{{Click URL}}"),
        parameter("TEMPLATE", "eventLabel", "{{Page URL}}"),
        parameter("TEMPLATE", "trackingId", "{{PLX - GA ID}}")
      );
      $temp_tag['firingTriggerId'] = array(
        88
      );

      // Telephone Trigger Filter
      $filter = array();
      $filter['type'] = "CONTAINS";
      $filter['parameter'] = array(
        parameter("TEMPLATE", "arg0", "{{Click URL}}"),
        parameter("TEMPLATE", "arg1", "tel:+44")
      );

      // Telephone Trigger
      $temp_trig = array();
      $temp_trig['accountId'] = $acc_id;
      $temp_trig['containerId'] = $con_id;
      $temp_trig['triggerId'] = 88;
      $temp_trig['type'] = "LINK_CLICK";
      $temp_trig['name'] = "PLX - Telephone Click";
      $temp_trig['filter'] = array(
        $filter
      );
      $temp_trig['waitForTags'] = array();
      $temp_trig['waitForTags']['type'] = "BOOLEAN";
      $temp_trig['waitForTags']['value'] = "false";
      $temp_trig['checkValidation'] = array();
      $temp_trig['checkValidation']['type'] = "BOOLEAN";
      $temp_trig['checkValidation']['value'] = "false";
      $temp_trig['waitForTagsTimeout'] = array();
      $temp_trig['waitForTagsTimeout']['type'] = "TEMPLATE";
      $temp_trig['waitForTagsTimeout']['value'] = 2000;
      $temp_trig['uniqueTriggerId'] = array();
      $temp_trig['uniqueTriggerId']['type'] = "TEMPLATE";

      // Push Tag and Trigger pair
      array_push($tag, $temp_tag);
      array_push($trigger, $temp_trig);
    }

  


  //**********************************//
  //****   OUTBOUND CLICK PAIR    ****//
  //**********************************//

    // Outbound Click
    $click_out = get_option( 'plx_reporting_json_outbound' );

    if($click_out){

      // Outbound Tag
      $temp_tag = array();
      $temp_tag['accountId'] = $acc_id;
      $temp_tag['containerId'] = $con_id;
      $temp_tag['tagId'] = 89;
      $temp_tag['name'] = "PLX - Outbound Click";
      $temp_tag['type'] = "ua";
      $temp_tag['tagFiringOption'] = "ONCE_PER_EVENT";
      $temp_tag['parameter'] = array(
        parameter("BOOLEAN", "nonInteraction", "false"),
        parameter("BOOLEAN", "overrideGaSettings", "true"),
        parameter("TEMPLATE", "eventCategory", "Click - Outbound"),
        parameter("TEMPLATE", "trackType", "TRACK_EVENT"),
        parameter("TEMPLATE", "eventAction", "{{Click URL}}"),
        parameter("TEMPLATE", "eventLabel", "{{Page URL}}"),
        parameter("TEMPLATE", "trackingId", "{{PLX - GA ID}}")
      );
      $temp_tag['firingTriggerId'] = array(
        89
      );

      // Outbound Trigger Filters
      $rep1 = parameter("TEMPLATE", "arg0", "{{Click URL}}");
      $rep2 = parameter("BOOLEAN", "negate", "true");

        // Filter out own url
        $filter1 = array();
        $filter1['type'] = "CONTAINS";
        $filter1['parameter'] = array(
          $rep1,
          $rep2,
          parameter("TEMPLATE", "arg1", $site_url )
        );
        // Filter our telephones
        $filter2 = array();
        $filter2['type'] = "CONTAINS";
        $filter2['parameter'] = array(
          $rep1,
          $rep2,
          parameter("TEMPLATE", "arg1", "tel:" )
        );
        // Filter out emails
        $filter3 = array();
        $filter3['type'] = "CONTAINS";
        $filter3['parameter'] = array(
          $rep1,
          $rep2,
          parameter("TEMPLATE", "arg1", "mailto:" )
        );

        // Filter for target = _blank
        $filter4 = array();
        $filter4['type'] = "EQUALS";
        $filter4['parameter'] = array(
          parameter("TEMPLATE", "arg0", "{{Click Target}}"),
          parameter("TEMPLATE", "arg1", "_blank" )
        );

      // Outbound Trigger
      $temp_trig = array();
      $temp_trig['accountId'] = $acc_id;
      $temp_trig['containerId'] = $con_id;
      $temp_trig['triggerId'] = 89;
      $temp_trig['type'] = "LINK_CLICK";
      $temp_trig['name'] = "PLX - Outbound Click";
      $temp_trig['filter'] = array( $filter1, $filter2, $filter3 );
      $temp_trig['waitForTags'] = array();
      $temp_trig['waitForTags']['type'] = "BOOLEAN";
      $temp_trig['waitForTags']['value'] = "false";
      $temp_trig['checkValidation'] = array();
      $temp_trig['checkValidation']['type'] = "BOOLEAN";
      $temp_trig['checkValidation']['value'] = "false";
      $temp_trig['waitForTagsTimeout'] = array();
      $temp_trig['waitForTagsTimeout']['type'] = "TEMPLATE";
      $temp_trig['waitForTagsTimeout']['value'] = 2000;
      $temp_trig['uniqueTriggerId'] = array();
      $temp_trig['uniqueTriggerId']['type'] = "TEMPLATE";

      // Push Tag and Trigger pair
      array_push($tag, $temp_tag);
      array_push($trigger, $temp_trig);
    }


  //**********************************//
  //****       Page View Tag      ****//
  //**********************************//

    // Pageview Opt
    $page_view = get_option( 'plx_reporting_json_pageview' );

    if($page_view){

      // Argh
      $temp = array();
      $temp['accountId'] = $acc_id;
      $temp['containerId'] = $con_id;
      $temp['name'] = "PLX Pageview Tag";
      $temp['tagId'] = 1;
      $temp['type'] = "ua";
      $temp['firingTriggerId'] = array(
        "2147479553"
      );
      $temp['parameter'] = array(
        parameter("BOOLEAN", "overrideGaSettings", "true"),
        parameter("TEMPLATE", "trackType", "TRACK_PAGEVIEW"),
        parameter("TEMPLATE", "trackingId", "{{PLX - GA ID}}")
      );

      // Push Tag
      array_push($tag, $temp);

    }