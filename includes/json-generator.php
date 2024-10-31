<?php
if (!defined('ABSPATH')) {
    die;
}

abstract class Json
{
    protected $tag_manager_id;
    protected $gtm_account_id;
    protected $ga4_measurment_id;
    protected $timedate;

    public function __construct($tag_manager_id, $gtm_account_id, $ga4_measurment_id)
    {
        $this->tag_manager_id =  $tag_manager_id;
        $this->gtm_account_id = $gtm_account_id;
        $this->ga4_measurment_id = $ga4_measurment_id;
        $this->timedate = date('Y-m-d H:i:s');
    }

    public static function find_and_replace_property($array, $key, $newValue)
    {
        
        foreach ($array as $k => $item) {
            if (is_array($item)) {
                if ($key == $k && array_key_exists($key, $array)) {
                    $array[$k] = $newValue;
                } else {
                    $array[$k] = self::find_and_replace_property($item, $key, $newValue);
                }
            } else if ($key == $k && array_key_exists($key, $array)) {
                $array[$k] = $newValue;
            }
        }
        return $array;
    }

    public static function find_and_replace_value($array, $key, $value, $newValue)
    {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $array[$k] = self::find_and_replace_value($v, $key, $value, $newValue);
            } else if ($k == $key && $v == $value) {
                $array[$k] = $newValue;
            }
        }
        return $array;
    }

    public static function find_and_merge_array($array, $key, $newArray)
    {
        foreach ($array as $k => $item) {
            if (is_array($item)) {
                if (is_numeric($k)) {
                    // indexed array
                    $array[$k] = self::find_and_merge_array($item, $key, $newArray);
                } else {
                    // associative array
                    if ($key == $k) {
                        $array[$k] = array_merge($item, $newArray);
                    } else {
                        $array[$k] = self::find_and_merge_array($item, $key, $newArray);
                    }
                }
            }
        }
        return $array;
    }

    public static function json_encode_empties_as_objects($data)
    {
        if (is_array($data)) {
            if (empty($data)) {
                return new stdClass();
            }

            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = self::json_encode_empties_as_objects($value);
            }
            return $result;
        }
        return $data;
    }

    public static function get_random_number()
    {
        return rand(10000000, 99999999);
    }

    abstract public function get_json();
}

class Ga4Json extends Json
{
    const JSON_TEMPLATE = PLX_REPORTING_PLUGIN_DIR . '/includes/json-templates/ga4.template.json';

    public function get_json()
    {
        $template = file_get_contents(self::JSON_TEMPLATE);
        $json = json_decode($template, true);

        // REPLACE PROPERTIES
        $replacementsProperties = [
            'accountId' => $this->gtm_account_id,
            'exportTime' => $this->timedate,
            'publicId' => $this->gtm_account_id,
        ];

        foreach ($replacementsProperties as $key => $value) {
            $json = self::find_and_replace_property($json, $key,  $value);
        }

        // KEY VALUE PAIRS 
        $replacementsValues = [
            [
                'key' => 'value',
                'value' => '{% MEASUREMENT_ID %}',
                'new_value' => $this->ga4_measurment_id
            ]
        ];

        foreach ($replacementsValues as $value) {
            $json = self::find_and_replace_value($json, $value['key'],  $value['value'], $value['new_value']);
        }

        // MERGES INDEXED ARRAYS
        $mergeValues = [
            'tagIds' => [$this->gtm_account_id]
        ];

        foreach ($mergeValues as $key => $value) {
            $json = self::find_and_merge_array($json, $key,  $value);
        }

        return json_encode(self::json_encode_empties_as_objects($json), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}

class adWordsJson extends Json
{
    const BASE_JSON_TEMPLATE = PLX_REPORTING_PLUGIN_DIR . '/includes/json-templates/ad-words-base.template.json';
    const TRIGGERS_JSON_TEMPLATE = PLX_REPORTING_PLUGIN_DIR . '/includes/json-templates/ad-words-triggers.template.json';
    const TAGS_JSON_TEMPLATE = PLX_REPORTING_PLUGIN_DIR . '/includes/json-templates/ad-words-tags.template.json';

    public function get_base_json()
    {
        $template = file_get_contents(self::BASE_JSON_TEMPLATE);
        $json = json_decode($template, true);

        $replacementsProperties = [
            'accountId' => $this->gtm_account_id,
            'exportTime' => $this->timedate,
            'publicId' => $this->gtm_account_id,
        ];

        foreach ($replacementsProperties as $key => $value) {
            $json = self::find_and_replace_property($json, $key,  $value);
        }

        return $json;
    }

    public function get_trigger_json(WP_Post $form)
    {
        $template = file_get_contents(self::TRIGGERS_JSON_TEMPLATE);
        $trigger_id = $this->get_random_number();
        $json = json_decode($template, true);

        $replacementsProperties = [
            'accountId' => $this->gtm_account_id,
            'triggerId' => $trigger_id,
            'name' => 'CF7 - ' . $form->ID . ' - ' . $form->post_title,
        ];

        foreach ($replacementsProperties as $key => $value) {
            $json = $this->find_and_replace_property($json, $key,  $value);
        }

        $replacementsValues = [
            [
                'key' => 'value',
                'value' => '{% FORM_ID %}',
                'new_value' => $form->ID
            ]
        ];

        foreach ($replacementsValues as $value) {
            $json = self::find_and_replace_value($json, $value['key'],  $value['value'], $value['new_value']);
        }

        return $json;
    }

    public function get_tag_json(WP_Post $form, $trigger_id)
    {
        $template = file_get_contents(self::TAGS_JSON_TEMPLATE);
        $json = json_decode($template, true);

        $replacementsProperties = [
            'accountId' => $this->gtm_account_id,
            'triggerId' => $trigger_id,
            'tagId' => $this->get_random_number(),
            'name' => 'Google Ads - Conv. - ' . $form->post_title,
        ];

        foreach ($replacementsProperties as $key => $value) {
            $json = $this->find_and_replace_property($json, $key,  $value);
        }

        $json = $this->find_and_merge_array($json, 'firingTriggerId',  [$trigger_id]);

        return $json;
    }

    public function get_form_data()
    {
        $data = [
            'trigger' => [],
            'tag' => []
        ];

        $query = new WP_Query([
            'post_type' => 'wpcf7_contact_form',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => '_plx_reporting_form_type',
                    'value' => 'lead',
                    'compare' => '='
                ]
            ]
        ]);

        $forms = $query->posts;

        foreach ($forms as $index => $form) {
            $trigger = $this->get_trigger_json($form);
            $data['trigger'][] = $trigger;
            $data['tag'][] = $this->get_tag_json($form, $trigger['triggerId']);
        }

        return $data;
    }

    public function get_json()
    {
        $json = $this->get_base_json();
        $mergeValues = array_merge($this->get_form_data(), ['tagIds' => [$this->gtm_account_id]]);

        foreach ($mergeValues as $key => $value) {
            $json = $this->find_and_merge_array($json, $key,  $value);
        }

        return json_encode($this->json_encode_empties_as_objects($json), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
