function ecr_FormItem() {
    const { registerBlockType } = wp.blocks;
    const {
        TextControl,
        SelectControl,
        CheckboxControl,
        Button,
        Dashicon
    } = wp.components;

    const baseField = {
        type: 'text',
        name: '',
        label: ''
    };

    var el = wp.element.createElement;

    registerBlockType('ecr/form-item', {
        title: 'Form Item',
        icon: 'media-text',
        category: 'common',
        supports: {
            customClassName: false,
        },
        attributes: {
            type: {
                type: 'string',
                default:'text'
            },
            name: {
                type: 'string',
                default: ''
            },
            label: {
                type: 'string',
                default: ''
            },
            required: {
                type: 'boolean',
                default: false
            }
        },
        edit: function(props) {
            return [
                el('div', { className: 'fields-row' }, [
                    el(SelectControl, {
                        label: "Type",
                        value: props.attributes.type,
                        options:  [
                            { label: 'Text', value: 'text' },
                            { label: 'Long Text', value: 'textarea' },
                            { label: 'Email', value: 'email' },
                            { label: 'Checkbox', value: 'checkbox' },
                            { label: 'Range', value: 'range' },
                            { label: 'Number', value: 'number' },
                            { label: 'Password', value: 'password' }
                        ],
                        onChange: ( value ) => {
                            props.setAttributes( { type: value } );
                        }
                    }),
                    el(TextControl, {
                        label: "Name",
                        value: props.attributes.name,
                        onChange: ( value ) => {
                            props.setAttributes( { name: value } );
                        }
                    }),
                    el(TextControl, {
                        label: "Label",
                        value: props.attributes.label,
                        onChange: ( value ) => {
                            props.setAttributes( { label: value } );
                        }
                    })
                ]),
                el('div', { className: 'fields=row' }, [
                    el(CheckboxControl, {
                        label: 'Required',
                        checked: props.attributes.required,
                        onChange: ( value ) => {
                            props.setAttributes( { required: value } );
                        }
                    })
                ])
            ];
        },
        save: function(props) {

            var options = {
                id: props.attributes.name,
                name: props.attributes.name,
                placeholder: props.attributes.label
            }

            if(props.attributes.type != 'textarea') options['type'] = props.attributes.type;
            if(props.attributes.type == 'checkbox') options['value'] = "yes";
            if(props.attributes.required) options['required'] = "";

            return el('div', { className: props.attributes.type == 'checkbox' ? 'form-group form-checkbox' : 'form-group'}, [
                el('label', { 
                        style: props.attributes.type == 'checkbox' ? {} : { display: 'none' }, 
                        for: props.attributes.name
                    },
                    props.attributes.label
                ),
                el(props.attributes.type == 'textarea' ? 'textarea':'input', options)
            ]);
        }
    });
}

ecr_FormItem();
