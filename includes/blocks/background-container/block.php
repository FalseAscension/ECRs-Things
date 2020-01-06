<?php

class ecr_BackgroundContainer
{
    function __construct() {}

    function blockRegistration()
    {
        // Editor Script
        wp_register_script(
            'ecr-background-container-block',
            plugins_url('js/block.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-editor'
            )
        );

        // Editor Style
        wp_register_style(
            'ecr-background-container-block',
            plugins_url('css/editor.css', __FILE__),
            array('wp-edit-blocks'),
            filemtime(plugin_dir_path( __FILE__ ) . 'css/editor.css')
        );

        register_block_type('ecr/background-container', array(
            'editor_script' => 'ecr-background-container-block',
            'editor_style'  => 'ecr-background-container-block',
            'render_callback' => array($this, 'render'),
        ));
    }

    function render($attributes, $content = '')
    {
        $context['content'] = $content;
        $context['background_color'] = $attributes['background_color'];

        $context['attributes'] = $attributes;

        $output = Timber::compile(ECR_PLUGIN_DIR . '/includes/templates/background-container.twig', $context);

        return $output;
    }
}

add_action('init', function(){
    $block = new ecr_BackgroundContainer();
    $block->blockRegistration();
});
