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
            submit: {
                type: 'string',
                default: 'Submit'
            } 
        },
        edit: function(props) {

            return [
                el('div', { className: props.className }, [
                    el(InnerBlocks, { 
                        allowedBlocks: [ 'ecr/form-item' ],
                        template: [ [ 'ecr/form-item', {} ] ]
                    }),
                    el(TextControl, {
                        className: 'submit',
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
