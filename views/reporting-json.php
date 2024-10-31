<div class="wrap">

  <h1>JSON Export</h1>

  <?php
    if ( isset( $_GET['settings-updated'] ) ) {
      add_settings_error( 'plx_reporting_messages', 'plx_reporting_message', __( 'Settings Saved' ), 'updated' );
    } settings_errors( 'plx_reporting_messages' ); ?>

  <form action="options.php" method="post">
    <?php
      settings_fields( 'plx-reporting-json' );
      do_settings_sections( 'plx-reporting-json' );
      submit_button( 'Configure JSON' );
    ?>
  </form>

</div>

<?php if ( isset( $_GET['settings-updated'] ) ):?>

  <div class="wrap">

  <?php
    // SETTING GENERIC DATA (move to json-builder when done!!)
    $gtm_id = get_option( 'plx_reporting_setting_GTMID' );
    $acc_id = get_option( 'plx_reporting_setting_ACCID' );
    $wpcf7s = get_option( 'plx_reporting_json_form' );
    $con_id = "1809911";
    $finger = 1510246166177;

    // Checking the validity of the GTM ID and Account ID
    
      // Returns true if string, atleast 10 characters and contains 'GTM-'
      $gtm_valid = ( ( gettype($gtm_id) == 'string' ) && ( strlen($gtm_id) >= 8 ) && ( strpos( $gtm_id, 'GTM-' ) !== false ) )? true : false ;
      
      // Returns true if string, atleast 10 characters
      $acc_valid = ( ( gettype($acc_id) == 'string' ) && ( strlen($acc_id) >= 8 ) )? true : false ;

      if( !$gtm_valid || !$acc_valid ):?>

  <h2 style="color:#f00">Incomplete Tag Manager Data</h2>
  <p style="color:#f00"><strong>Some of your details don't seem to be correctly filled in, please go back and check the <?php if( !$gtm_valid && !$acc_valid ):?>GTM ID and GTM Account ID<?php elseif(!$gtm_valid):?>GTM ID<?php elseif(!$acc_valid):?>GTM Account ID<?php endif;?> field<?php if( !$gtm_valid && !$acc_valid ):?>s<?php endif;?>.</strong></p>

      <?php else: ?>

    <h2>Your JSON is served</h2>
    <p>Copy and paste the below code into a local .json file and then import into your Google Tag Manager account.</p>

    <div class="plx_reporting_codeblock" style="background: #1b1b1b; padding: 1em 1em 0em; box-sizing: border-box; color: #888; position: relative; overflow: hidden;">
      <pre>
        <code>
          <?php require_once('php-json/json-builder.php'); ?>
        </code>
      </pre>
    </div>
    

        <?php endif;?>

  </div>

<?php endif; ?>