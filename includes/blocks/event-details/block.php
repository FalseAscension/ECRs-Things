<?php

class ecr_EventDetails
{
    function __construct() {
        add_action('init', array($this, 'blockRegistration'));
        add_action('init', array($this, 'meta'));
        add_action('register_post_type_args', array($this, 'eventTemplate'), 20, 2); // Filters args when a post type is registered
    }

    function blockRegistration()
    {
        // Editor Script
        wp_register_script(
            'ecr-event-details-block',
            plugins_url('js/block.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-editor',
                'moment'
            )
        );

        // Editor Style
        wp_register_style(
            'ecr-event-details-block',
            plugins_url('css/editor.css', __FILE__),
            array('wp-edit-blocks'),
            filemtime(plugin_dir_path( __FILE__ ) . 'css/editor.css')
        );

        register_block_type('ecr/event-details', array(
            'editor_script' => 'ecr-event-details-block',
            'editor_style'  => 'ecr-event-details-block',
        ));
    }

    function meta() {
        register_meta('post', 'ecr_event_details_location', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => "string",
            'object_subtype' => "ecr_event"
        ));
        register_meta('post', 'ecr_event_details_postcode', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => "string",
            'object_subtype' => "ecr_event"
        ));
        register_meta('post', 'ecr_event_details_start', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => "string",
            'object_subtype' => "ecr_event"
        ));
        register_meta('post', 'ecr_event_details_end', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => "string",
            'object_subtype' => "ecr_event"
        ));
    }

    // Place self into post type ecr_event by default
    function eventTemplate($args, $postType) {
        if($postType == "ecr_event") {
            $args['template'] = [
                [
                    'ecr/event-details', []
                ]
            ];
        }

        return $args;
    }
}

new ecr_EventDetails();
