function ecr_EventList(){
    const { registerBlockType } = wp.blocks;
    
    const {} = wp.editor;

    /* An awesome tutorial on InspectorControls https://rudrastyh.com/gutenberg/inspector-controls.html 
     * WP component reference https://developer.wordpress.org/block-editor/components/ */

    const {
        TextControl,
        SelectControl,
    } = wp.components;

    var el = wp.element.createElement;

    registerBlockType('ecr/event-list', {
        title: 'Event List',
        icon: 'editor-ul',
        category: 'common',
        supports: {
        },
        attributes: {
            n: {
                type: 'int',
                default: -1
            },
            wrap: {
                type: 'string',
                default: 'wrap'
            },
            type: {
                type: 'string',
                default: ''
            }
        },

        edit: function(props) {
            
            return [
                el('div', { style: { display: 'flex' } }, 
                    el(TextControl, 
                        {
                            label: 'n',
                            type: 'number',
                            onChange: ( value ) => {
                                if(!isNaN(value)) props.setAttributes( { n: Number(value) } );
                            },
                            value: props.attributes.n
                        }
                    ),
                    el(SelectControl, 
                        {
                            label: 'Display Style',
                            onChange: ( value ) => {
                                props.setAttributes( { wrap: value } );
                            },
                            options: [
                                { value: 'wrap', label: 'Grid' },
                                { value: 'scroll', label: 'Scroll Horizontally' }
                            ],
                            value: props.attributes.wrap
                        }
                    )
                ),
                el(TextControl, 
                    {
                        label: 'Event Type',
                        onChange: ( value ) => {
                            props.setAttributes( { type: value } )
                        },
                        value: props.attributes.type
                    }
                )
            ];
        },

        save: function(props) {
            return null; // Render in PHP
        }
    });
}

ecr_EventList();
