function ecr_Hero() {
    const { registerBlockType } = wp.blocks;
    
    const { 
        InnerBlocks 
    } = wp.blockEditor;

    /* An awesome tutorial on InspectorControls https://rudrastyh.com/gutenberg/inspector-controls.html 
     * WP component reference https://developer.wordpress.org/block-editor/components/ */

    const {
    } = wp.components;

    var el = wp.element.createElement;

    registerBlockType('ecr/hero', {
        title: 'Hero Container',
        icon: 'schedule',
        category: 'layout',
        supports: {
            customClassName: false,
        },
        attributes: {
        },

        edit: function(props) {
            return [
                el('div', {className: props.className },
                    el(InnerBlocks) 
                )
            ];
        },

        save: function(props) {
            return (
                el('div', { classNameL 'hero' }, el(InnerBlocks.Content))
            );
        },
    });
}

ecr_Hero();
