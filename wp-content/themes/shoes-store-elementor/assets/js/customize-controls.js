( function( api ) {

	// Extends our custom "shoes-store-elementor" section.
	api.sectionConstructor['shoes-store-elementor'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );