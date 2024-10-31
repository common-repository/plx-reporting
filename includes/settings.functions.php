<?php

  // Callback for top level settings group
  function plx_reporting_setcall_credentials(){
    echo '<p>Configure your reporting implementation below.</p>';
  }

  // Callback for JSON settings group
  function plx_reporting_setcall_json(){
    echo '<p>Configure your outputted JSON for import to Google Tag Manager.</p>';
  }
  
  // Callback for JSON Google Analytics VAR
  function plx_reporting_setcall_json_GAID( $args ){
    $options = get_option( 'plx_reporting_json_GAID' );
    $show = get_option( 'plx_reporting_setting_GAID' );
    if( ( strlen($show) >= 4 ) && ( gettype($show)=='string' ) && ( strpos($show, 'UA-') !== false ) ):
    ?>
    <input id="<?php echo esc_attr( $args['label_for'] ); ?>" name="<?php echo esc_attr( $args['label_for'] ); ?>" class="<?php echo esc_attr( $args['class'] ); ?>" value="1" type="<?php echo esc_attr( $args['type'] ); ?>" <?php echo ($options) ? 'checked' : ''; ?> >
    <?php else: ?>
    <input style="display:none;" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="<?php echo esc_attr( $args['label_for'] ); ?>" class="<?php echo esc_attr( $args['class'] ); ?>" value="1" type="<?php echo esc_attr( $args['type'] ); ?>" <?php echo ($options) ? 'checked' : ''; ?> >
    <p><em>To insert this variable, please enter a valid Google Analytics ID.</em></p>
    <?php endif;
  }
  
  // Dynamic Callback for all checkboxes
  function plx_reporting_setcall_checkbox( $args ){
    $options = get_option( $args['label_for'] ); ?>
    <input id="<?php echo esc_attr( $args['label_for'] ); ?>" name="<?php echo esc_attr( $args['label_for'] ); ?>" class="<?php echo esc_attr( $args['class'] ); ?>" value="1" type="<?php echo esc_attr( $args['type'] ); ?>" <?php echo ($options) ? 'checked' : ''; ?> >
    <?php
  }

  // Dynamic text field Callback
  function plx_reporting_setcall_text( $args ){
    $options = get_option( $args['label_for'] );
    $required = array_key_exists( 'required', $args ) ? $args['required'] : false ;
    if ( isset( $_GET['settings-updated'] ) && ( $required === true ) && ( $options === '' ) ):?>
      <p><strong style="color:#f00">This is a required field.</strong></p>
    <?php endif; ?>
    <input id="<?php echo esc_attr( $args['label_for'] ); ?>" name="<?php echo esc_attr( $args['label_for'] ); ?>" class="<?php echo esc_attr( $args['class'] ); ?>" value="<?php echo $options; ?>" type="<?php echo esc_attr( $args['type'] ); ?>" >
    <?php
  }
  
  // Dynamic text field Callback
  function plx_reporting_setcall_textarea( $args ){
    $options = get_option( $args['label_for'] );
    ?>

    <textarea id="<?php echo esc_attr( $args['label_for'] ); ?>" name="<?php echo esc_attr( $args['label_for'] ); ?>" rows="5" cols="80"><?php echo $options; ?></textarea>
    <?php
  }