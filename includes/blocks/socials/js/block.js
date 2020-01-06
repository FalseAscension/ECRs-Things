function ecr_Socials(){
    const { registerBlockType } = wp.blocks;
    
    const { 
    } = wp.editor;

    /* An awesome tutorial on InspectorControls https://rudrastyh.com/gutenberg/inspector-controls.html 
     * WP component reference https://developer.wordpress.org/block-editor/components/ */

    const {
        TextControl,
    } = wp.components;

    var el = wp.element.createElement;

    registerBlockType('ecr/socials', {
        title: 'Social Icons',
        icon: 'networking',
        category: 'common',
        supports: {
            customClassName: false,
        },
        attributes: {
            instagram: {
                type: 'string',
                default: ''
            },
            facebook: {
                type: 'string',
                default: ''
            },            
            twitter: {
                type: 'string',
                default: ''
            },            
            donate: {
                type: 'string',
                default: ''
            },
        },

        edit: function(props) {
            
            return [
                el('h1', {}, 'Social Icons'),
                el(TextControl, 
                    {
                        label: 'Instagram',
                        onChange: ( value ) => {
                            props.setAttributes( { instagram: value } );
                        },
                        value: props.attributes.instagram
                    }
                ),
                el(TextControl, 
                    {
                        label: 'Facebook',
                        onChange: ( value ) => {
                            props.setAttributes( { facebook: value } );
                        },
                        value: props.attributes.facebook
                    }
                ),
                el(TextControl, 
                    {
                        label: 'Twitter',
                        onChange: ( value ) => {
                            props.setAttributes( { twitter: value } );
                        },
                        value: props.attributes.twitter
                    }
                ),                
                el(TextControl, 
                    {
                        label: 'Donate',
                        onChange: ( value ) => {
                            props.setAttributes( { donate: value } );
                        },
                        value: props.attributes.donate
                    }
                )
            ];
        },

        save: function(props) {
            return; // render in php
        },
    });
}

ecr_Socials();
