<?php 
  if( get_option( 'plx_reporting_json_BIV' ) ): ?>
  {
                      "accountId": "<?php echo $acc_id; ?>",
                      "containerId": "<?php echo $con_id; ?>",
                      "type": "PAGE_URL",
                      "name": "Page URL"
                    },
                    {
                        "accountId": "<?php echo $acc_id; ?>",
                        "containerId": "<?php echo $con_id; ?>",
                        "type": "PAGE_HOSTNAME",
                        "name": "Page Hostname"
                    },
                    {
                        "accountId": "<?php echo $acc_id; ?>",
                        "containerId": "<?php echo $con_id; ?>",
                        "type": "PAGE_PATH",
                        "name": "Page Path"
                    },
                    {
                        "accountId": "<?php echo $acc_id; ?>",
                        "containerId": "<?php echo $con_id; ?>",
                        "type": "REFERRER",
                        "name": "Referrer"
                    },
                    {
                        "accountId": "<?php echo $acc_id; ?>",
                        "containerId": "<?php echo $con_id; ?>",
                        "type": "EVENT",
                        "name": "Event"
                    },
                    {
                        "accountId": "<?php echo $acc_id; ?>",
                        "containerId": "<?php echo $con_id; ?>",
                        "type": "CLICK_ELEMENT",
                        "name": "Click Element"
                    },
                    {
                        "accountId": "<?php echo $acc_id; ?>",
                        "containerId": "<?php echo $con_id; ?>",
                        "type": "CLICK_CLASSES",
                        "name": "Click Classes"
                    },
                    {
                        "accountId": "<?php echo $acc_id; ?>",
                        "containerId": "<?php echo $con_id; ?>",
                        "type": "CLICK_ID",
                        "name": "Click ID"
                    },
                    {
                        "accountId": "<?php echo $acc_id; ?>",
                        "containerId": "<?php echo $con_id; ?>",
                        "type": "CLICK_TARGET",
                        "name": "Click Target"
                    },
                    {
                        "accountId": "<?php echo $acc_id; ?>",
                        "containerId": "<?php echo $con_id; ?>",
                        "type": "CLICK_URL",
                        "name": "Click URL"
                    },
                    {
                        "accountId": "<?php echo $acc_id; ?>",
                        "containerId": "<?php echo $con_id; ?>",
                        "type": "CLICK_TEXT",
                        "name": "Click Text"
                    }
  <?php endif; ?>