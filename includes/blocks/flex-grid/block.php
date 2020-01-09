<?php

class ecr_FlexGrid
{
    function __construct() {}

    function blockRegistration()
    {
        // Editor Script
        wp_register_script(
            'ecr-flex-grid-block',
            plugins_url('js/block.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-editor'
            )
        );

        // Editor Style
        wp_register_style(
            'ecr-flex-grid-block',
            plugins_url('css/editor.css', __FILE__),
            array('wp-edit-blocks'),
            filemtime(plugin_dir_path( __FILE__ ) . 'css/editor.css')
        );

        register_block_type('ecr/flex-grid', array(
            'editor_script' => 'ecr-flex-grid-block',
            'editor_style'  => 'ecr-flex-grid-block',
            'render_callback' => array($this, 'render'),
        ));
    }

    function render($attributes, $content = '')
    {
        $context['content'] = $content;
        if(isset($attributes['columns'])) $context['columns'] = $attributes['columns'];
        else $context['columns'] = 3;

        $context['attributes'] = $attributes;

        $output = Timber::compile(ECR_PLUGIN_DIR . '/includes/templates/flex-grid.twig', $context);

        return $output;
    }
}

add_action('init', function(){
    $block = new ecr_FlexGrid();
    $block->blockRegistration();
});
