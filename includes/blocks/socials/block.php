<?php

class ecr_Socials
{
    function __construct() {}

    function blockRegistration()
    {
        // Editor Script
        wp_register_script(
            'ecr-socials-block',
            plugins_url('js/block.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-editor'
            )
        );

        // Editor Style
        wp_register_style(
            'ecr-socials-block',
            plugins_url('css/editor.css', __FILE__),
            array('wp-edit-blocks'),
            filemtime(plugin_dir_path( __FILE__ ) . 'css/editor.css')
        );

        register_block_type('ecr/socials', array(
            'editor_script' => 'ecr-socials-block',
            'editor_style'  => 'ecr-socials-block',
            'render_callback' => array($this, 'render'),
        ));
    }

    function render($attributes, $content = '')
    {
        $context['content'] = $content;
        $context['attributes'] = $attributes;
        $context['icondir'] = plugin_dir_url(__FILE__) . 'images';


        $output = Timber::compile(ECR_PLUGIN_DIR . '/includes/templates/socials.twig', $context);

        return $output;
    }
}

add_action('init', function(){
    $block = new ecr_Socials();
    $block->blockRegistration();
});
