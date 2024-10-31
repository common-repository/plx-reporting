<?php

    require('tag-trigger-setup.php');

    $i = 0;
    if( $forms_length > 0 ):
    foreach($forms as $form): ?><?php if($i===0):?>

                <?php endif;?>
    {
                  "tagId": "3",
                  "accountId": "<?php echo $acc_id; ?>",
                  "containerId": "<?php echo $con_id; ?>",
                  "name": "CF7 - <?php echo $form;?> - <?php echo strtolower(get_the_title($form));?>",
                  "type": "ua",
                  "parameter": [
                      {
                          "type": "BOOLEAN",
                          "key": "nonInteraction",
                          "value": "false"
                      },
                      {
                          "type": "BOOLEAN",
                          "key": "overrideGaSettings",
                          "value": "true"
                      },
                      {
                          "type": "TEMPLATE",
                          "key": "eventValue",
                          "value": "Form Label"
                      },
                      {
                          "type": "TEMPLATE",
                          "key": "eventCategory",
                          "value": "Form Category"
                      },
                      {
                          "type": "TEMPLATE",
                          "key": "trackType",
                          "value": "TRACK_EVENT"
                      },
                      {
                          "type": "TEMPLATE",
                          "key": "eventAction",
                          "value": "Form Action"
                      },
                      {
                          "type": "TEMPLATE",
                          "key": "eventLabel",
                          "value": "Form Label"
                      },
                      {
                          "type": "TEMPLATE",
                          "key": "trackingId",
                          "value": "{{PLX GA ID}}"
                      }
                  ],
                  "fingerprint": "1510247430674",
                  "firingTriggerId": [
                      "<?php echo $form; ?>"
                  ],
                  "tagFiringOption": "ONCE_PER_EVENT"
                }<?php if( ( ($i+1) < $forms_length ) || ( $ctc_tags_size > 0 ) ):?>,<?php endif;?>

<?php
            $i++;
        endforeach;
    endif;

    // CLICK TAGS

        // Looping the prepped array for JSON
        $i = 0;
        if($ctc_tags_size):
        foreach($ctc_tags as $ctc_tag): ?>
            {
                "accountId": "<?php echo $acc_id; ?>",
                "containerId": "<?php echo $con_id; ?>",
                "tagId": "2",
                "name": "PLX - Click <?php echo ucfirst($ctc_tag); ?>",
                "type": "ua",
                "parameter": [
                    {
                        "type": "BOOLEAN",
                        "key": "nonInteraction",
                        "value": "false"
                    },
                    {
                        "type": "BOOLEAN",
                        "key": "overrideGaSettings",
                        "value": "true"
                    },
                    {
                        "type": "TEMPLATE",
                        "key": "eventCategory",
                        "value": "Click - <?php echo ucfirst($ctc_tag); ?>"
                    },
                    {
                        "type": "TEMPLATE",
                        "key": "trackType",
                        "value": "TRACK_EVENT"
                    },
                    {
                        "type": "TEMPLATE",
                        "key": "eventAction",
                        "value": "{{Click URL}}"
                    },
                    {
                        "type": "TEMPLATE",
                        "key": "eventLabel",
                        "value": "{{Page URL}}"
                    },
                    {
                        "type": "TEMPLATE",
                        "key": "trackingId",
                        "value": "{{PLX GA ID}}"
                    }
                ],
                "fingerprint": "1508142250905",
                "firingTriggerId": [
                    "69<?php echo $i; ?>"
                ],
                "tagFiringOption": "ONCE_PER_EVENT"
            } <?php if( ( $i + 1 ) < $ctc_tags_size ):?>,<?php endif; ?>
        <?php $i++;
    endforeach;
    endif;
    

    // PAGEVIEW TAG

    $ctc_pview = get_option( 'plx_reporting_json_pageview' );