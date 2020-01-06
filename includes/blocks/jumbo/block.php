<?php

class ecr_Jumbo
{
    function __construct() {}

    function blockRegistration()
    {
        // Editor Script
        wp_register_script(
            'ecr-jumbo-block',
            plugins_url('js/block.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-editor'
            )
        );

        // Editor Style
        wp_register_style(
            'ecr-jumbo-block',
            plugins_url('css/editor.css', __FILE__),
            array('wp-edit-blocks'),
            filemtime(plugin_dir_path( __FILE__ ) . 'css/editor.css')
        );

        register_block_type('ecr/jumbo', array(
            'editor_script' => 'ecr-jumbo-block',
            'editor_style'  => 'ecr-jumbo-block',
            'render_callback' => array($this, 'render'),
        ));
    }

    function render($attributes, $content = '')
    {
        $context['content'] = $content;
        if(array_key_exists('id', $attributes)) $context['id'] = $attributes['id'];
        $context['attributes'] = $attributes;

        $output = Timber::compile(ECR_PLUGIN_DIR . '/includes/templates/jumbo.twig', $context);

        return $output;
    }
}

add_action('init', function(){
    $block = new ecr_Jumbo();
    $block->blockRegistration();
});
