<?php

class ecr_SlideshowBlock
{
    function __construct() {}

    function blockRegistration()
    {
        // Editor Script
        wp_register_script(
            'ecr-slideshow-block',
            plugins_url('js/block.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-editor',
                'wp-data'
            )
        );

        // Editor Style
        wp_register_style(
            'ecr-slideshow-block',
            plugins_url('css/editor.css', __FILE__),
            array('wp-edit-blocks'),
            filemtime(plugin_dir_path( __FILE__ ) . 'css/editor.css')
        );

        // Frontend Scripts
        wp_register_script(
            'responsive-slides',
            plugins_url('js/responsiveslides.min.js', __FILE__),
            array('jquery')
        );

        wp_register_script(
            'ecr-slideshow',
            plugins_url('js/slideshow.js', __FILE__),
            array(
                'jquery',
                'responsive-slides'
            )
        );

        // Frontend Style
        wp_register_style(
            'ecr-slideshow',
            plugins_url('css/slideshow.css', __FILE__)
        );

        register_block_type('ecr/slideshow-block', array(
            'editor_script' => 'ecr-slideshow-block',
            'editor_style'  => 'ecr-slideshow-block',
            'script' => 'ecr-slideshow',
            'style' => 'ecr-slideshow',
            'render_callback' => array($this, 'render'),
        ));
    }

    function render($attributes, $content = '')
    {
        $context['items'] = $attributes['items'];
        unset($attributes['items']);
        $context['attributes'] = $attributes;

        $output = Timber::compile(ECR_PLUGIN_DIR . '/includes/templates/slideshow.twig', $context);

        return $output;
    }
}

add_action('init', function(){
    $block = new ecr_SlideshowBlock();
    $block->blockRegistration();
});
