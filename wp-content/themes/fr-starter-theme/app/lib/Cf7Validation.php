<?php
if (!class_exists('Cf7Validation')) :

    class Cf7Validation
    {

        public function __construct()
        {
            // Other constructor code...

            // Add filter to validate CF7 text fields for blank spaces
            add_filter('wpcf7_validate_text*', [$this, 'validateCF7TextField'], 10, 2);
            add_filter('wpcf7_validate_textarea*', [$this, 'validateCF7TextField'], 10, 2); // Add this line for textarea fields
        }

        // Other methods...

        // Validate CF7 text fields for blank spaces
        public function validateCF7TextField($result, $tag)
        {
            $field_names_to_validate = ['first_name', 'last_name', 'message']; // Add 'Message' here

            // Check if the field name matches the text fields you want to validate
            if (in_array($tag['name'], $field_names_to_validate)) {
                $value = isset($_POST[$tag['name']]) ? trim($_POST[$tag['name']]) : '';

                // Check if the value contains only blank spaces
                if (empty($value) || strlen($value) === 0) {
                    $result->invalidate($tag, "Blank spaces are not allowed.");
                }

                // Check if the value contains only numbers or only special characters
                if ($tag['name'] !== 'message' && (ctype_digit($value) || preg_match('/^[[:punct:]]+$/', $value))) {
                    $result->invalidate($tag, "Numbers and special characters are not allowed.");
                }
            }

            return $result;
        }
    }

    // Initialize class
    global $Cf7Validation;
    $Cf7Validation = new \Cf7Validation();
endif;
