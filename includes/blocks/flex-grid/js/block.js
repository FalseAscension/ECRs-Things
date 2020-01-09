function ecr_FlexGrid() {
    const { registerBlockType } = wp.blocks;
    
    const { 
        InspectorControls,
        InnerBlocks 
    } = wp.blockEditor;

    /* An awesome tutorial on InspectorControls https://rudrastyh.com/gutenberg/inspector-controls.html 
     * WP component reference https://developer.wordpress.org/block-editor/components/ */

    const {
        PanelBody,
        RangeControl
    } = wp.components;

    var el = wp.element.createElement;

    registerBlockType('ecr/flex-grid', {
        title: 'Flex Grid',
        icon: 'screenoptions',
        category: 'layout',
        supports: {
            customClassName: false,
        },
        attributes: {
            columns: {
                type: 'int',
                default: 3
            }
        },

        edit: function(props) {
            
            return [
                el(InspectorControls, {},
                    el(PanelBody, {title: 'Columns'},
                        el(RangeControl, 
                            {
                                label: 'Columns',
                                onChange: ( value ) => {
                                    props.setAttributes( { columns: value } );
                                },
                                value: props.attributes.columns,
                                min: 2,
                                max: 10
                            }
                        )
                    )
                ),
                el('div', {className: props.className + ' columns-' + props.attributes.columns},
                    el(InnerBlocks) 
                )
            ];
        },

        save: function(props) {
            return el(InnerBlocks.Content);
        },
    });
}

ecr_FlexGrid();
