<?php

class ecr_FormsPage {

    public function __construct() {
        add_action('admin_menu', array($this, 'page_init'));
    }

    public function page_init(){
        $main = add_menu_page('Forms', 'Forms', 'publish_posts', 'ecr_forms_page', array($this, 'render'), 'dashicons-edit', 26);
        // Sub menus: https://developer.wordpress.org/reference/functions/add_submenu_page/
        
        add_action('load-' . $main, array($this, 'load_scripts'));
    }

    public function load_scripts() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function enqueue_scripts() {
        wp_register_style(
            'ecr_forms_page',
            plugins_url('forms.css', __FILE__)
        );

        wp_enqueue_style('ecr_forms_page');
    }

    public function render(){
        $context = array();

        $dbObj = new ecr_DB;

        $forms = $dbObj->get_slugs('form_data');
        $context['forms'] = $forms;

        $data = array();
        foreach($forms as $form) {
            $data[$form['slug']] = array_map(
                function($r) {
                    return json_decode($r['data'], true);
                },
                $dbObj->get_data($form['slug'])
            );
        }
        $context['data'] = $data;

        echo Timber::compile(ECR_PLUGIN_DIR . '/includes/templates/admin_forms_page.twig', $context); 
    }
}

new ecr_FormsPage();
