function ecr_Reveal () {
    const { registerBlockType } = wp.blocks;
    const { 
        InnerBlocks,
        InspectorControls
    } = wp.blockEditor;
    const {
        TextControl,
        TextareaControl,
        PanelBody,
        ColorPalette
    } = wp.components;
    var el = wp.element.createElement;


    registerBlockType('ecr/reveal', {
        title: 'Reveal',
        icon: 'media-text',
        category: 'common',
        supports: {
            customClassName: false,
        },

        attributes: {
            title: {
                type: 'string',
                default: ''
            },
            visibleText: {
                type: 'string',
                default: ''
            },
            color: {
                type: 'string',
                default: ''
            }
        },

        edit: function(props) {
            const { setAttributes } = props;
            const { attributes } = props;

            function saveTitle(title) {
                setAttributes({
                    title: title
                });
            }

            function saveVisibleText(visibleText) {
                setAttributes({
                    visibleText: visibleText
                });
            }

            return [
                el(InspectorControls, {}, 
                    el(PanelBody, {title: 'Colors'}, 
                        el(ColorPalette, {
                            value: props.attributes.color,
                            onChange: (value) => {
                                props.setAttributes({ color: value });
                            },
                            colors: [
                                { name: 'black', color: "#fff" },
                                { name: 'white', color: "#000" }
                            ]
                        })
                    )
                ),
                el('div', { className: props.className },
                    el('div', { className: 'title' },
                        el(TextControl, {
                            label: 'Reveal title',
                            value: attributes.title,
                            onChange: function(data) {
                                saveTitle(data);
                            }
                        })
                    ),
                    el('div', { className: 'visible-text' },
                        el(TextareaControl, {
                            label: 'Reveal visible text (optional)',
                            value: attributes.visibleText,
                            onChange: function(data) {
                                saveVisibleText(data);
                            }
                        })
                    ),
                    el('div', { className: 'visible-text' },
                        el(InnerBlocks, {
                            template: [
                                ['core/paragraph', { placeholder: 'Enter hidden content...' }]
                            ]
                        })
                    )
                )
            ];
        },

        save: function(props) {
            return (
                el(InnerBlocks.Content)
            );
        },
    });
}

ecr_Reveal();
