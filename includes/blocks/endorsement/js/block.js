function ecr_Endorsement(){
    const { registerBlockType } = wp.blocks;
    
    const { 
        MediaUpload
    } = wp.editor;

    /* An awesome tutorial on InspectorControls https://rudrastyh.com/gutenberg/inspector-controls.html 
     * WP component reference https://developer.wordpress.org/block-editor/components/ */

    const {
        TextControl,
        Button
    } = wp.components;

    var el = wp.element.createElement;

    registerBlockType('ecr/endorsement', {
        title: 'Profile',
        icon: 'admin-users',
        category: 'common',
        supports: {
            customClassName: false,
        },
        attributes: {
            thumbnail: {
                type: 'object',
                default: null
            },
            name: {
                type: 'string',
                default: ''
            },
            credentials: {
                type: 'string',
                default: ''
            }
        },

        edit: function(props) {
            
            return [
                el(MediaUpload,
                    {
                        type: 'image',
                        onSelect: (image) => {
                            props.setAttributes( { thumbnail: image } );
                        },
                        render: (obj) => {
                            if(props.attributes.thumbnail) {
                                return el('div', {className: 'components-media-upload'}, 
                                    el('img', {src: props.attributes.thumbnail.url, onClick: obj.open, className: 'components-media-upload-img'}),
                                    el(Button, 
                                        {
                                                className: 'components-button components-media-upload__clear-button', 
                                                onClick: function() {
                                                    props.setAttributes( { thumbnail: null } );
                                                }
                                            }, 'Clear image'
                                        )
                                )
                            } else {
                                return el('div', {className: 'components-media-upload'},
                                    el(Button, {className: 'components-button components-media-upload__button', onClick: obj.open}, 'Add image')
                                )
                            }
                        }
                    }
                ),
                el(TextControl, 
                    {
                        label: 'Name',
                        onChange: ( value ) => {
                            props.setAttributes( { name: value } );
                        },
                        value: props.attributes.name
                    }
                ),
                el(TextControl, 
                    {
                        label: 'Credentials',
                        onChange: ( value ) => {
                            props.setAttributes( { credentials: value } );
                        },
                        value: props.attributes.credentials
                    }
                ),


            ];
        },

        save: function(props) {
            return null;
        },
    });
}

ecr_Endorsement();
