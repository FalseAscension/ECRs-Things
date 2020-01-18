<?php

class ecr_Reveal
{
    function __construct() {}

    function blockRegistration()
    {
        // Editor Script
        wp_register_script(
            'ecr-reveal-block',
            plugins_url('js/block.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-editor'
            )
        );
        
        // Editor Style
        wp_register_style(
            'ecr-reveal-block',
            plugins_url('css/editor.css', __FILE__),
            array('wp-edit-blocks'),
            filemtime(plugin_dir_path( __FILE__ ) . 'css/editor.css')
        );

        // Frontend Script
        wp_register_script(
            'ecr-reveal',
            plugins_url('js/reveal.js', __FILE__),
            array('jquery')
        );

        register_block_type('ecr/reveal', array(
            'editor_script' => 'ecr-reveal-block',
            'editor_style'  => 'ecr-reveal-block',
            'script' => 'ecr-reveal',
            'render_callback' => array($this, 'render'),
        ));
    }

    function render($attributes, $content = '')
    {
        if(isset($attributes['title'])) $context['title'] = $attributes['title'];
        if(isset($attributes['visibleText'])) $context['visibleText'] = $attributes['visibleText'];
        if(isset($attributes['color'])) $context['color'] = $attributes['color'];
        $context['attributes'] = $attributes;

        $context['hiddenContent'] = $content;

        return Timber::compile(ECR_PLUGIN_DIR . '/includes/templates/reveal.twig', $context);
    }
}

add_action('init', function(){
    $block = new ecr_Reveal();
    $block->blockRegistration();
});
