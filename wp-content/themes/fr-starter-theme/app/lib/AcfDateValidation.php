<?php
if (!class_exists('AcfDateValidation')) :

    class AcfDateValidation
    {

        public function __construct()
        {
            add_action( 'acf/validate_save_post', [$this, 'ValidateDate'] );
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
        
        
    }
    /**
     * Initialize class
     */
    global $AcfDateValidation;
    $AcfDateValidation = new \AcfDateValidation();
endif;
