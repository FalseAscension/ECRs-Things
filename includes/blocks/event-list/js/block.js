function ecr_EventList(){
    const { registerBlockType } = wp.blocks;
    
    const {} = wp.editor;

    /* An awesome tutorial on InspectorControls https://rudrastyh.com/gutenberg/inspector-controls.html 
     * WP component reference https://developer.wordpress.org/block-editor/components/ */

    const {
        TextControl,
        SelectControl
    } = wp.components;

    var el = wp.element.createElement;

    registerBlockType('ecr/event-list', {
        title: 'Event List',
        icon: 'editor-ul',
        category: 'common',
        supports: {
            customClassName: false,
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
        },

        edit: function(props) {
            
            return [
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
                        label: 'Wraping Style',
                        onChange: ( value ) => {
                            props.setAttributes( { wrap: value } );
                        },
                        options: [
                            { value: 'wrap', label: 'Wrap Line' },
                            { value: 'scroll', label: 'Scroll Horizontally' }
                        ]
                    }
                ),


            ];
        },

        save: function(props) {
            return null; // Render in PHP
        }
    });
}

ecr_EventList();
