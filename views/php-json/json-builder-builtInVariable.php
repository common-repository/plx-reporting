<?php

  //*********************************//
  //****     builtInVariable     ****//
  //*********************************//

    // Boolean for including builtInVariables
    $option_builtInVariable = get_option( 'plx_reporting_json_BIV' );

    // Static list of builtInVariables
    $static_bivs = [
      "Page URL",
      "Page Hostname",
      "Page Path",
      "Referrer",
      "Event",
      "Click Element",
      "Click Classes",
      "Click ID",
      "Click Target",
      "Click URL",
      "Click Text"
    ];

    // Function to convert static bivs to "type"
    function static_type( $str ){
      $to_upper = strtoupper($str);
      $underscored = str_replace(" ", "_", $to_upper);
      return $underscored;
    };

    // If including builtInVariables
    if($option_builtInVariable):

      // Loop static builtInVariables
      foreach( $static_bivs as $static_biv ):

        // Build builtInVariable
        $biv = array();
        $biv['accountId'] = $acc_id;
        $biv['containerId'] = $con_id;
        $biv['type'] = static_type( $static_biv );
        $biv['name'] = $static_biv;

        // Push to builtInVariable Array
        array_push($builtInVariable, $biv);

      endforeach;

    endif;