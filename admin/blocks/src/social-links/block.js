const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { SelectControl, Panel, PanelBody, PanelRow } = wp.components;
const { Component, RawHTML } = wp.element;
const { RichText, MediaUpload, InspectorControls, PanelColorSettings  } = wp.editor;



class editSocialLinks extends Component {

    constructor() {
      super( ...arguments );

      this.getInspectorControls = this.getInspectorControls.bind(this);

      this.onChangelinkSize = this.onChangelinkSize.bind(this);
      this.onChangelinkDirection = this.onChangelinkDirection.bind(this);
      this.onChangelinksAlign = this.onChangelinksAlign.bind(this);

    }

    getInspectorControls( options ) {
       return(

          <InspectorControls>

            <PanelBody
            title="Social Link Settings"
            initialOpen={ true }
            className="blueprint-panel-body">

            <SelectControl
              label="Align Links:"
              value={ this.props.attributes.linksAlign }
              options={ [
                { label: 'Center', value: 'center' },
                { label: 'Left', value: 'start' },
                { label: 'Right', value: 'end' },
                { label: 'Space Evenly, Fill Width', value: 'space-between'}
              ] }
              onChange={ this.onChangelinksAlign }
            />

            <SelectControl
              label="Link Display Direction:"
              value={ this.props.attributes.linkDirection }
              options={ [
                { label: 'Row', value: 'row' },
                { label: 'Column', value: 'column' },
                { label: 'Row (reverse order)', value: 'row-reverse' },
                { label: 'Column (reverse order)', value: 'column-reverse'}
              ] }
              onChange={ this.onChangelinkDirection }
            />

            <SelectControl
              label="Link Size:"
              value={ this.props.attributes.linkSize }
              options={ [
                { label: 'Mini', value: 'mini' },
                { label: 'Small', value: 'small' },
                { label: 'Normal', value: 'normal' },
                { label: 'Medium', value: 'medium'},
                { label: 'Large', value: 'large' },
                { label: 'Extra Large', value: 'xlarge' },

              ] }
              onChange={ this.onChangelinkSize }
            />

          </PanelBody>

          </InspectorControls>
       );
    }

    onChangelinkSize( newValue ) {
    this.props.setAttributes({ linkSize: newValue });
    }
    onChangelinkDirection( newValue ) {
    this.props.setAttributes({ linkDirection: newValue });
    }
    onChangelinksAlign( newValue ) {
    this.props.setAttributes({ linksAlign: newValue });
    }

    render() {
        let blockStyle = {};
        let buttonStyle = {};



		return (
            <div className={ this.props.className }
              style={ blockStyle }>

            <this.getInspectorControls/>

            </div>
		)
	}
}

registerBlockType( 'blueprint-social/social-links', {
	title: __( 'Social Links' ),
  icon: {
    // Specifying a background color to appear with the icon e.g.: in the inserter.
    background: '#fff',
    // Specifying a color for the icon (optional: if not set, a readable color will be automatically defined)
    foreground: '#49A5C3',
    // Specifying a dashicon for the block
    src: 'share',
  },
	category: 'blueprint-blocks',
	keywords: [
		__( 'Social' ),
    __( 'Blueprint Social' ),
    __( 'Facebook' ),
	],
  supports: {
    align: [ 'left', 'right', 'center', 'wide', 'full', ],
    anchor: true,
  },
	attributes: {
        linksAlign: {
          type: 'string',
          default: 'start'
        },
        linkDirection: {
          type: 'string',
          default: 'row',
        },
        linkSize: {
            type: 'string',
            default: 'normal',
        },
        linkInclude: {
            type: 'string',
        },
        linkExclude: {
            type: 'string',
        },
	  },

	edit: editSocialLinks,

	save: function( props ) {
    const align = `align="${props.attributes.linksAlign}"`;
    const size = `size="${props.attributes.linkSize}"`;
    const direction = `direction="${props.attributes.linkDirection}"`;
    const sClass= `class="${props.className}"`;

    const shortcode = `[blueprint_social ${align} ${size} ${direction} ${sClass}]`;
		return (

        <RawHTML>{ shortcode }</RawHTML>

		  );
	},
} );
