<?php

class ecr_DBForm {

    private $post_prefix;

    function __construct() {
        add_action('wp_ajax_ecr_signup_form', array($this, 'ecr_signup_form'));
        add_action('wp_ajax_nopriv_ecr_signup_form', array($this, 'ecr_signup_form'));
    }

    // This function is called when submitting the form via AJAX.
    function ecr_signup_form() {   
        $response = $this->submitForm($_POST['data']);

        if(count($response['errors']) > 0) {
            wp_send_json_error( $response );
        } else {
            wp_send_json_success( $response );
        }
        exit;
    }
    
    function submitForm($data) {
        $response = $this->validateForm($data['data']);

        if(!$response['success']) {
            return $response;
        }
        
        $ecrdb = new ecr_DB();

        $an = $ecrdb->insert_data('form_data',
            json_encode($data['data']),
            $data['slug']
        );
    
        if(!$an) {
            $response['success'] = false;
            $response['errors']['an'] = $an;
        }

        return $response;
    }

    function validateForm($data) {
        $response = array(
            'errors' => array(),
            'success' => false
        );

        // Name Field: required
        if(empty($data['name'])) $response['errors']['name_required'] = "Please enter your name.";

        // Email Field: required, must be an email address
        if(empty($data['email'])) $response['errors']['email_required'] = "Please enter your email address.";
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $response['errors']['email'] = "Please enter a valid email address.";

        // gdpr_consent required
        if(empty($data['gdpr-consent']) || $data['gdpr-consent'] != "yes") $response['errors']['gdpr-consent'] = "You must consent to receiving communication from us.";

        if(count($response['errors']) == 0) {
            $response['success'] = true;
        }

        return $response;
    }
}

new ecr_DBForm;
