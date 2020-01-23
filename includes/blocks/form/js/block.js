function ecr_Form() {
    const { 
        registerBlockType 
    } = wp.blocks;
    const {
        TextControl,
    } = wp.components;
    const {
        InnerBlocks
    } = wp.blockEditor

    const baseField = {
        type: 'text',
        name: '',
        label: ''
    };

    var el = wp.element.createElement;

    registerBlockType('ecr/form', {
        title: 'Form',
        icon: 'media-text',
        category: 'common',
        supports: {
            customClassName: false,
        },
        attributes: {
            slug: {
                type: 'string',
                default: ''
            },
            submit: {
                type: 'string',
                default: 'Submit'
            } 
        },
        edit: function(props) {

            return [
                el('div', { className: props.className }, [
                    el(TextControl, {
                        label: 'Form Name',
                        value: props.attributes.slug,
                        onChange: ( value ) => {
                            props.setAttributes( { slug: value } );
                        }
                    }),
                    el(InnerBlocks, { 
                        allowedBlocks: [ 'ecr/form-item' ],
                        template: [ [ 'ecr/form-item', {} ] ]
                    }),
                    el(TextControl, {
                        className: 'submit',
                        label: 'submit',
                        value: props.attributes.submit,
                        onChange: ( value ) => {
                            props.setAttributes( { submit: value } );
                        }
                    })
                ])
            ];
        },
        save: function(props) {
            return el(InnerBlocks.Content);
        }
    });
}

ecr_Form();
