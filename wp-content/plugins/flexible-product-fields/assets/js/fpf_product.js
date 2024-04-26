jQuery(document).ready(function() {

	function fpf_variation_price() {
		jQuery.each(fpf_fields,function(i,val){
			if ( val.has_price && val.price_type == 'percent' && val.price != 0 ) {
				val.price_value = fpf_product_price * val.price / 100;
				var price_display = accounting.formatMoney( val.price_value, {
					symbol 		: fpf_product.currency_format_symbol,
					decimal 	: fpf_product.currency_format_decimal_sep,
					thousand	: fpf_product.currency_format_thousand_sep,
					precision 	: fpf_product.currency_format_num_decimals,
					format		: fpf_product.currency_format
				} );
				val.price_display = val.price_value;
				var selector = '#'+val.id+'_price';
				jQuery(selector).html('(' + price_display + ')');
			}
			if (val.has_options) {
				jQuery.each(val.options, function (i, val_option) {
					if ( val_option.price_type == 'percent' ) {
						val_option.price_value = fpf_product_price * val_option.price / 100;
						var price_display = accounting.formatMoney( val_option.price_value, {
							symbol 		: fpf_product.currency_format_symbol,
							decimal 	: fpf_product.currency_format_decimal_sep,
							thousand	: fpf_product.currency_format_thousand_sep,
							precision 	: fpf_product.currency_format_num_decimals,
							format		: fpf_product.currency_format
						} );
						val_option.price_display = val_option.price_value;
						if ( val.type == 'select' || val.type == 'multiselect' ) {
							var option_selector = '#' + val.id + ' option[value="'+val_option.value+'"]';
							jQuery(option_selector).text( val_option.label + ' (' + price_display + ')' );
						}
						if ( val.type == 'radio' || val.type == 'radio-images' || val.type == 'radio-colors' || val.type == 'multi-checkbox' ) {
							var option_selector = '#' + val.id + '_' + val_option.value + '_price';
							jQuery(option_selector).text( '(' + price_display + ')' );
						}
					}
				});
			}
		});
	}

	function fpf_price_options( field ) {
		var qty = jQuery('input.qty').val(),
			wrap = jQuery('#fpf_totals');
		wrap.empty();
		var adjust_price = 0;
		var adjusted_price = false;
		jQuery.each(fpf_fields,function(i,val){
			var price_displays  = [];
			var price_values    = [];
			var calculate_price = true;
			if ( typeof fpf_product.fields_rules[val.id] !== 'undefined' ) {
				if ( !fpf_product.fields_rules[val.id].enabled ) {
					calculate_price = false;
				}
			}
			if ( calculate_price ) {
				if (!val.has_options && val.has_price && val.price_value != 0) {
					if (val.type == 'text' || val.type == 'textarea' || val.type == 'number' || val.type == 'email' || val.type == 'url' || val.type == 'fpfdate' || val.type == 'time' || val.type == 'color') {
						var field_val = jQuery('#' + val.id).val();
						if (field_val != '') {
							price_displays.push( val.price_display );
						}
					}
					if (val.type == 'checkbox') {
						if (jQuery('#' + val.id).is(':checked')) {
							price_displays.push( val.price_display );
						}
					}
					if (val.type == 'file') {
						var file_fields = jQuery('[name="' + val.id + '_file[]"]');
						jQuery.each( file_fields, function( file_index, file_field ) {
							if ( file_field.value !== '') {
								price_displays.push( val.price_display );
								price_values.push( file_field.value );
							}
						});
					}
				}
				if (val.has_options) {
					jQuery.each(val.options, function (i, val_option) {
						if (val.type == 'select') {
							var field_val = jQuery('#' + val.id).val();
							if (field_val == val_option.value) {
								price_displays.push( val_option.price_display );
							}
						}
						if (val.type == 'multiselect') {
							var field_vals = jQuery('[id="' + val.id + '"]').val();
							jQuery.each( field_vals, function( val_index, field_val ) {
								if ( field_val == val_option.value) {
									price_displays.push( val_option.price_display );
									price_values.push( val_option.label );
								}
							});
						}
						if (val.type == 'multi-checkbox') {
							var field_val = jQuery('[name="' + val.id + '[]"][value="' + val_option.value + '"]:checked').val();
							if ( field_val ) {
								price_displays.push( val_option.price_display );
								price_values.push( val_option.label );
							}
						}
						if (val.type == 'radio' || val.type == 'radio-images' || val.type == 'radio-colors') {
							var field_val = jQuery('input[name=' + val.id + ']:checked').val()
							if (field_val == val_option.value) {
								price_displays.push( val_option.price_display );
							}
						}
					});
				}
			}
			jQuery.each( price_displays, function( i, price_display ) {
				if ( typeof price_display === 'undefined' ) {
					return;
				}

				var price_value = price_display * qty;
				price_display   = accounting.formatMoney( price_value, {
					symbol 		: fpf_product.currency_format_symbol,
					decimal 	: fpf_product.currency_format_decimal_sep,
					thousand	: fpf_product.currency_format_thousand_sep,
					precision 	: fpf_product.currency_format_num_decimals,
					format		: fpf_product.currency_format
				} );
				var price_label = price_values[ i ];
				if ( typeof price_label === 'undefined' ) {
					wrap.append('<dt>' + val.title + ':</dt>');
				} else {
					wrap.append('<dt>' + val.title + ' ('  + price_label + '):</dt>');
				}
				wrap.append('<dd>' + price_display + '</dd>');
				adjust_price += price_value;
				adjusted_price = true;
			});
		});
		if ( adjusted_price ) {
			var total_price = ( qty * fpf_product_price ) + adjust_price;
			total_price = accounting.formatMoney( total_price, {
				symbol 		: fpf_product.currency_format_symbol,
				decimal 	: fpf_product.currency_format_decimal_sep,
				thousand	: fpf_product.currency_format_thousand_sep,
				precision 	: fpf_product.currency_format_num_decimals,
				format		: fpf_product.currency_format
			} );
			wrap.append('<dt>' + fpf_product.total + ':</dt>');
			wrap.append('<dd>' + total_price + '</dd>');
		}
	}

	if ( typeof fpf_fields != 'undefined' ) {
		fpf_price_options();
	}
	jQuery(document).on("change",".fpf-input-field,input.qty",function() {
		fpf_price_options(this);
	});
	jQuery(document).on("keyup",".fpf-input-field,input.qty,.variations select",function() {
		fpf_price_options(this);
	});

	jQuery(document).on( 'found_variation', 'form.cart', function( event, variation ) {
		fpf_product_price = variation.display_price;
		fpf_variation_price();
		fpf_price_options();
	});

	jQuery(document).on( 'click', '.fpf-fields-config', function( event, variation ) {
		var values = jQuery( 'form.cart' ).serialize().split( '&' );
		var items  = [];
		var keys   = [];

		var length = fpf_fields.length;
		for ( var i = 0; i < length; i++ ) {
			var field_key = fpf_fields[ i ].id;
			if ( fpf_fields[ i ].type === 'multiselect' ) {
				field_key += '[]';
			}
			keys.push( field_key );
		}

		jQuery.each( values, function( i, val ) {
			var field_data = val.split( '=' );
			if ( ( keys.indexOf( decodeURIComponent( field_data[0] ) ) === -1 ) || ( field_data[1] === '' ) ) {
				return;
			}
			items.push( val );
		});
		if ( ! items ) {
			return;
		}

		var new_url = jQuery( 'form.cart' ).attr( 'action' );
		new_url += '?' + items.join( '&' );
		location.replace( new_url );
	});
})
