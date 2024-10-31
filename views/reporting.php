<div class="wrap">

  <h1>PLX Reporting</h1>

  <?php
    if ( isset( $_GET['settings-updated'] ) ) {
      add_settings_error( 'plx_reporting_messages', 'plx_reporting_message', __( 'Settings Saved' ), 'updated' );
    } settings_errors( 'plx_reporting_messages' ); ?>

  <form action="options.php" method="post">
    <?php
      settings_fields( 'plx-reporting' );
      do_settings_sections( 'plx-reporting' );
      submit_button( 'Save Settings' );
    ?>
  </form>

</div>