<?php

  $ua_id = get_option( 'plx_reporting_setting_GAID' );
  $ua_check = get_option( 'plx_reporting_json_GAID' );
  $ua_include = ( ( strpos($ua_id, 'UA-') !== false ) && $ua_check );
  $plx_data = get_option( 'plx_reporting_json_PLXDATA' );

  if( $ua_include ):?>
                {
                  "accountId": "<?php echo $acc_id; ?>",
                  "containerId": "<?php echo $con_id; ?>",
                  "variableId": "1",
                  "name": "PLX - GA ID",
                  "type": "c",
                  "parameter": [
                    {
                      "type": "TEMPLATE",
                      "key": "value",
                      "value": "UA-98867695-15"
                    }
                  ],
                  "fingerprint": "1510245525077"
<?php
  endif;
  if( $ua_include && $plx_data ):?>
                },
<?php elseif( $ua_include ): ?>
                }
<?php endif; ?>
<?php if( $plx_data ):?>
                {
                  "accountId": "<?php echo $acc_id; ?>",
                  "containerId": "<?php echo $con_id; ?>",
                  "variableId": "2",
                  "name": "PLX - Form ID",
                  "type": "v",
                  "parameter": [
                    {
                      "type": "INTEGER",
                      "key": "dataLayerVersion",
                      "value": "2"
                    },
                    {
                      "type": "BOOLEAN",
                      "key": "setDefaultValue",
                      "value": "false"
                    },
                    {
                      "type": "TEMPLATE",
                      "key": "name",
                      "value": "plx_data"
                    }
                  ],
                  "fingerprint": "1510246166177"
                }
<?php endif; ?>