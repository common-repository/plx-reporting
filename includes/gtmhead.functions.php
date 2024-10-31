<?php

  // Adds Relevant GTM tags
  function plx_reporting_gtm_head(){

    // If injection setting is true and GTMID exists
    if( get_option( 'plx_reporting_setting_inj' ) && ( get_option( 'plx_reporting_setting_GTMID' ) !== '' ) ){

      // <head> script
      echo "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','".get_option( 'plx_reporting_setting_GTMID' )."');</script>";

      $body_1 = "<noscript><iframe src='https://www.googletagmanager.com/ns.html?id=";
      $body_2 = "'height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>";
      $body_noscript = $body_1.get_option( 'plx_reporting_setting_GTMID' ).$body_2;

      // Inline JS to prepend <body> script
      echo '<script>
        document.addEventListener("DOMContentLoaded", function(event) {
          var s = document.body.firstChild;
          var script = "'.$body_noscript.'";
          document.body.innerHTML+script;
        });
      </script>';
    }
  }
  // Add hook for front-end <head></head>
  add_action('wp_head', 'plx_reporting_gtm_head');