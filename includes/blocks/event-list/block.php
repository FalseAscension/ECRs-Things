<?php

class ecr_eventList
{
    function __construct() {}

    function blockRegistration()
    {
        // Editor Script
        wp_register_script(
            'ecr-event-list-block',
            plugins_url('js/block.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-editor'
            )
        );

        // Editor Style
        wp_register_style(
            'ecr-event-list-block',
            plugins_url('css/editor.css', __FILE__),
            array('wp-edit-blocks'),
            filemtime(plugin_dir_path( __FILE__ ) . 'css/editor.css')
        );

        register_block_type('ecr/event-list', array(
            'editor_script' => 'ecr-event-list-block',
            'editor_style'  => 'ecr-event-list-block',
            'render_callback' => array($this, 'render'),
        ));
    }

    function render($attributes, $content = '')
    {
        $context['content'] = $content; 

        $eventsObj = new ecr_Events;

        $taxQuery = array();
        if(isset($attributes['type'])) {
            $taxQuery[] = array(
                'taxonomy' => $eventsObj->taxonomyType,
                'field' => 'slug',
                'terms' => $attributes['type']
            );
        }

        $eventsQuery = $eventsObj->query(array(
            'posts_per_page' => (isset(attributes['n']) ? $attributes['n'] : -1),
            'tax_query' => $taxQuery
        ));

        $context['events'] = $eventsObj->getEvents($eventsQuery);
        $context['attributes'] = $attributes;

        return Timber::compile(ECR_PLUGIN_DIR . '/includes/templates/event-list.twig', $context);

    }
}

add_action('init', function(){
    $block = new ecr_eventList();
    $block->blockRegistration();
});
