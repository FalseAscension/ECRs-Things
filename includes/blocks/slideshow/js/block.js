/*import {
  withSelect,
} from '@wordpress/data';*/

function ecr_SlideshowBlock(){
    const { registerBlockType, getBlockContent } = wp.blocks;
    
    const { 
        InspectorControls,
        InnerBlocks,
    } = wp.blockEditor;

    const {
        PanelBody,
        PanelRow,
        ToggleControl,
        RangeControl
    } = wp.components;

    const {
        withSelect
    } = wp.data;

    /* An awesome tutorial on InspectorControls https://rudrastyh.com/gutenberg/inspector-controls.html 
     * WP component reference https://developer.wordpress.org/block-editor/components/ 
     * Full list of stock icons https://developer.wordpress.org/resource/dashicons/ */

    var el = wp.element.createElement;

    function blockEdit(props) {

    }

    registerBlockType('ecr/slideshow-block', {
        title: "ECR's Slideshow",
        icon: 'leftright',
        category: 'layout',
        supports: {
        },
        attributes: {
            items: {
                type: 'object',
                default: []
            },
            auto: {
                type: 'boolean',
                default: true
            },
            speed: {
                type: 'integer',
                default: 500
            },
            timeout: {
                type: 'integer',
                default: 10000
            },
            nav: {
                type: 'boolean',
                default: false
            },
            pager: {
                type: 'boolean',
                default: false
            }
        },

        edit: withSelect( ( select, ownProps ) => {
            return { innerBlocks: select( 'core/editor' ).getBlocks( ownProps.clientId ) };
        } )(( props ) => {

            var items = props.innerBlocks.map( block => getBlockContent(block) );
            if( JSON.stringify(props.attributes.items) != JSON.stringify(items)) // REACT.js reached maximum update depth without this.
                props.setAttributes( { items: items } );

            return [
                el(InspectorControls, {}, [
                    el('p', {}, 'This plugin is built upon responsiveSlides: http://responsiveslides.com/'),
                    el(PanelBody, {title: "Transition Settings"}, [
                        el(ToggleControl, {
                            label: 'Auto Change',
                            onChange: value => {
                                props.setAttributes( { auto: value } );
                            },
                            checked: props.attributes.auto
                        }),
                        el(RangeControl, {
                            label: 'Transition Speed',
                            onChange: value => {
                                props.setAttributes( { speed: value } );
                            },
                            value: props.attributes.speed,
                            min: 0,
                            max: 5000
                        }),
                        el(RangeControl, {
                            label: 'Transition Period',
                            onChange: value => {
                                props.setAttributes( { timeout: value } );
                            },
                            value: props.attributes.timeout,
                            min: 1000,
                            max: 100000
                        })
                    ]),
                    el(PanelBody, {title: "Navigation Settings" }, [
                        el(ToggleControl, {
                            label: 'Show Navigation Arrows',
                            onChange: value => {
                                props.setAttributes( { nav: value } );
                            },
                            checked: props.attributes.nav
                        }),
                        el(ToggleControl, {
                            label: 'Show Pager',
                            onChange: value => {
                                props.setAttributes( { pager: value } );
                            },
                            checked: props.attributes.pager
                        }),
                        el('p', {}, "Navigation arrows are yet to be styled in CSS. You can add your own CSS, though.")

                    ])
                ]),
                el('div', {className: props.className}, el(InnerBlocks))
            ];
        }),

        save: function(props) {
            return el(InnerBlocks.Content); // Render in php/twig (this line seems necessary to save innerblocks)
        },



    });
}

ecr_SlideshowBlock();
