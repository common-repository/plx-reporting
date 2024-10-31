<?php

  require('tag-trigger-setup.php');

  $i = 0;
  if( $forms_length > 0 ):
    foreach($forms as $form): ?><?php if($i===0):?>

  <?php endif; ?>
{
                    "accountId": "<?php echo $acc_id; ?>",
                    "containerId": "<?php echo $con_id; ?>",
                    "triggerId": "<?php echo $form; ?>",
                    "name": "CF7 - <?php echo $form;?> - <?php echo strtolower(get_the_title($form));?>",
                    "type": "CUSTOM_EVENT",
                    "customEventFilter": [
                      {
                        "type": "EQUALS",
                        "parameter": [
                          {
                            "type": "TEMPLATE",
                            "key": "arg0",
                            "value": "{{_event}}"
                          },
                          {
                            "type": "TEMPLATE",
                            "key": "arg1",
                            "value": "plx_form"
                          }
                        ]
                      }
                    ],
                    "filter": [
                      {
                        "type": "EQUALS",
                        "parameter": [
                          {
                            "type": "TEMPLATE",
                            "key": "arg0",
                            "value": "{{PLX FORM DATA}}"
                          },
                          {
                            "type": "TEMPLATE",
                            "key": "arg1",
                            "value": "<?php echo $form;?>"
                          }
                        ]
                      }
                    ],
                    "fingerprint": "1510247430672"
                  }<?php if( ($i+1) < $forms_length ):?>,<?php endif; ?>
<?php $i++;
    endforeach;
  endif;

      // Looping the prepped array for JSON
      $i = 0;
      if($ctc_tags_size):
      foreach($ctc_tags as $ctc_tag): ?>
            {
              "accountId": "<?php echo $acc_id; ?>",
              "containerId": "<?php echo $con_id; ?>",
              "triggerId": "69<?php echo $i;?>",
              "name": "PLX - Click <?php echo ucfirst( $ctc_tag );?>",
              "type": "LINK_CLICK",
              "filter": [
                {
                  "type": "CONTAINS",
                  "parameter": [
                    {
                      "type": "TEMPLATE",
                      "key": "arg0",
                      "value": "{{Click URL}}"
                    },
                    {
                      "type": "TEMPLATE",
                      "key": "arg1",
                      <?php 
                        switch( $ctc_tag ){
                          case "mail":
                            echo '"value": "mailto:"';
                            break;
                          case "outbound":
                            echo '"value": "'.$site_url.'"';
                            break;
                          case "tel":
                            echo '"value": "mailto"';
                            break;
                        }; ?>

                    }<?php if($ctc_tag=='outbound'):?>,
                    {
                      {
                          "type": "BOOLEAN",
                          "key": "negate",
                          "value": "true"
                      }
                    }
                    <?php endif; ?>
                  ]
                }
              ],
              "waitForTags": {
                "type": "BOOLEAN",
                "value": "false"
              },
              "checkValidation": {
                "type": "BOOLEAN",
                "value": "false"
              },
              "waitForTagsTimeout": {
                "type": "TEMPLATE",
                "value": "2000"
              },
              "uniqueTriggerId": {
                "type": "TEMPLATE"
              },
              "fingerprint": "1508142247021"
            }
          <?php
          endforeach;
        endif;