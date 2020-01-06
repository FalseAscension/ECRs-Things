<?php

class ecr_Hero
{
    function __construct() {}

    function blockRegistration()
    {
        // Editor Script
        wp_register_script(
            'ecr-hero-block',
            plugins_url('js/block.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-editor'
            )
        );

        // Editor Style
        wp_register_style(
            'ecr-hero-block',
            plugins_url('css/editor.css', __FILE__),
            array('wp-edit-blocks'),
            filemtime(plugin_dir_path( __FILE__ ) . 'css/editor.css')
        );

        register_block_type('ecr/hero', array(
            'editor_script' => 'ecr-hero-block',
            'editor_style'  => 'ecr-hero-block',
        ));
    }

    function customMeta() { // We will store the rendered InnerBlocks in post meta, to be retrieved by the theme. Hacky but it works.
        register_meta('post', 'ecr_hero', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string'
        ));
    }
}

add_action('init', function(){
    $block = new ecr_Hero();
    $block->blockRegistration();
});
