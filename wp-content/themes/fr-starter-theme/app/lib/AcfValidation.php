<?php
if (!class_exists('AcfValidation')) :

    class AcfValidation
    {

        public function __construct()
        {
            add_action( 'acf/validate_save_post', [$this, 'ValidateDate'] );
            add_filter( 'acf/validate_value/name=school_email', [$this, 'ValidateEmail'], 10, 4);
            add_filter( 'acf/validate_value/name=school_phone_number', [$this, 'ValidatePhoneNumber'], 10, 4);
        }


        // Validate dates
        public function ValidateDate() {
            if(!isset($_POST['acf']['field_camp_fields_start_date'])){
                return;
            }

            $startDate = $_POST['acf']['field_camp_fields_start_date'];
            $startDate = new DateTime($startDate);

            $endDate = $_POST['acf']['field_camp_fields_end_date'];
            $endDate = new DateTime($endDate);

            // check custom $_POST data
            if ($startDate > $endDate) {
                acf_add_validation_error('acf[field_camp_fields_end_date]', 'End Date should be greater than or Equal to Start Date');
            }

            // Validation start time and end time
            $startTime = $_POST['acf']['field_camp_fields_after_care']['field_camp_fields_after_care_start_time'];
            $startTime = new DateTime($startTime);

            $endTime = $_POST['acf']['field_camp_fields_after_care']['field_camp_fields_after_care_end_time'];
            $endTime = new DateTime($endTime);

            // check custom $_POST data
            if ($startTime > $endTime) {
                acf_add_validation_error('acf[field_camp_fields_after_care][field_camp_fields_after_care_end_time]', 'End Time should be greater than or Equal to Start Time');
            }

        }

        // Validate email
        public function ValidateEmail($valid, $value, $field, $input_name) {
            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                // field returns invalid and show this error message
                return __('Enter valid email.');
            }

            return $valid;
        }

        // Validate phonenumber
        public function ValidatePhoneNumber($valid, $value, $field, $input_name) {
            if (preg_match('/^[+][0-9]/', $value)) { //is the first character + followed by a digit
                $count = 1;
                $value = str_replace(['+'], '', $value, $count); //remove +
            }
            
            //remove white space, dots, hyphens and brackets
            $value = str_replace([' ', '.', '-', '(', ')'], '', $value); 
        
            //are we left with digits only?
            if(!$this->isDigits($value, 9, 14)){ 
                // field returns invalid and show this error message
                return __('Enter valid phone number.');
            }

            return $valid;
        }

        public function isDigits(string $s, int $minDigits = 9, int $maxDigits = 14): bool {
            return preg_match('/^[0-9]{'.$minDigits.','.$maxDigits.'}\z/', $s);
        }
        
        
    }
    /**
     * Initialize class
     */
    global $AcfValidation;
    $AcfValidation = new \AcfValidation();
endif;
