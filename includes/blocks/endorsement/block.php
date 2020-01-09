<?php

class ecr_Endorsement
{
    function __construct() {}

    function blockRegistration()
    {
        // Editor Script
        wp_register_script(
            'ecr-endorsement-block',
            plugins_url('js/block.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-editor'
            )
        );

        // Editor Style
        wp_register_style(
            'ecr-endorsement-block',
            plugins_url('css/editor.css', __FILE__),
            array('wp-edit-blocks'),
            filemtime(plugin_dir_path( __FILE__ ) . 'css/editor.css')
        );

        register_block_type('ecr/endorsement', array(
            'editor_script' => 'ecr-endorsement-block',
            'editor_style'  => 'ecr-endorsement-block',
            'render_callback' => array($this, 'render'),
        ));
    }

    function render($attributes, $content = '')
    {
        $context['content'] = $content;
        if(array_key_exists('thumbnail', $attributes)) $context['thumbnail'] = new TimberImage($attributes['thumbnail']);
        if(array_key_exists('name', $attributes)) $context['name'] = $attributes['name'];
        if(array_key_exists('credentials', $attributes)) $context['credentials'] = $attributes['credentials'];

        $context['attributes'] = $attributes;

        $output = Timber::compile(ECR_PLUGIN_DIR . '/includes/templates/endorsement.twig', $context);

        return $output;
    }
}

add_action('init', function(){
    $block = new ecr_Endorsement();
    $block->blockRegistration();
});
