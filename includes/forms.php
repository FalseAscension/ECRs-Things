<?php

class ecr_FormsPage {

    public function __construct() {
        add_action('admin_menu', array($this, 'page_init'));
    }

    public function page_init(){
        add_menu_page('Forms', 'Forms', 'publish_posts', 'ecr_forms_page', array($this, 'render'), 'dashicons-edit', 6);
    }

    public function render(){
        $context = array();

       echo Timber::compile(ECR_PLUGIN_DIR . '/includes/templates/admin_forms_page.twig', $context); 
    }
}

new ecr_FormsPage();
