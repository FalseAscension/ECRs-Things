<?php

class ecr_Form
{
    function __contruct() {}

    function blockRegistration()
    {
        // Editor Script
        wp_register_script(
            'ecr-form-block',
            plugins_url('js/block.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-editor'
            )
        );
        wp_register_script(
            'ecr-form-item-block',
            plugins_url('js/item.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-editor'
            )
        );

        // Editor Style
        wp_register_style(
            'ecr-form-block',
            plugins_url('css/editor.css', __FILE__),
            array('wp-edit-blocks'),
            filemtime(plugin_dir_path( __FILE__ ) . 'css/editor.css')
        );

        // Frontend Script
        wp_register_script(
            'ecr-form',
            plugins_url('js/submit.js', __FILE__),
            array(
                'jquery'
            )
        );
        wp_localize_script('ecr-form', 'ajax_url', admin_url('admin-ajax.php'));

        register_block_type('ecr/form', array(
            'editor_script' => 'ecr-form-block',
            'editor_style'  => 'ecr-form-block',
            'script' => 'ecr-form',
            'render_callback' => array($this, 'render'),
        ));
        register_block_type('ecr/form-item', array(
            'script' => 'ecr-form-item-block'
        ));
    }

    function render($attributes, $content = '')
    {
        if(isset($attributes['submit'])) $context['submit'] = $attributes['submit'];
        if(isset($attributes['slug'])) $context['slug'] = $attributes['slug'];

        $context['content'] = $content;
        $context['attributes'] = $attributes;

        $output = Timber::compile(ECR_PLUGIN_DIR . '/includes/templates/form.twig', $context);
    
        return $output;
    }
}

add_action('init', function(){
    $block = new ecr_Form();
    $block->blockRegistration();
});
