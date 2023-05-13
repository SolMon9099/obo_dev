(function( $ ) {
	'use strict';
	jQuery( '.multiselect2' ).select2();

	function allowSpeicalCharacter( str ) {
		return str.replace( '&#8211;', '–' ).replace( '&gt;', '>' ).replace( '&lt;', '<' ).replace( '&#197;', 'Å' );
	}

	function productFilter() {
		jQuery( '.product_fees_conditions_values_product' ).each( function() {
			$( '.product_fees_conditions_values_product' ).select2( {
				ajax: {
					url: coditional_vars.ajaxurl,
					dataType: 'json',
					delay: 250,
					cache: true,
                    minimumInputLength: 3,
					data: function( params ) {
						return {
							value: params.term,
							action: 'wcpfc_pro_product_fees_conditions_values_product_ajax',
                            _page: params.page || 1,
                            posts_per_page: 10 
						};
					},
					processResults: function( data ) {
						var options = [], more = true;
						if ( data ) {
							$.each( data, function( index, text ) {
								options.push( { id: text[ 0 ], text: allowSpeicalCharacter( text[ 1 ] ) } );
							} );
						}
                        //for stop paination on all data laod 
                        if( 0 === options.length ){ 
                            more = false; 
                        }
						return {
							results: options,
                            pagination: {
                                more: more
                            }
						};
					},
				},
			} );
		} );
	}

	function varproductFilter() {
		$( '.product_fees_conditions_values_var_product' ).each( function() {
			$( '.product_fees_conditions_values_var_product' ).select2( {
				ajax: {
					url: coditional_vars.ajaxurl,
					dataType: 'json',
					delay: 250,
                    cache: true,
                    minimumInputLength: 3,
					data: function( params ) {
						return {
							value: params.term,
							action: 'wcpfc_pro_product_fees_conditions_varible_values_product_ajax',
                            _page: params.page || 1,
                            posts_per_page: 10 
						};
					},
					processResults: function( data ) {
						var options = [], more = true;
						if ( data ) {
							$.each( data, function( index, text ) {
								options.push( { id: text[ 0 ], text: allowSpeicalCharacter( text[ 1 ] ) } );
							} );
						}
                        //for stop paination on all data laod 
                        if( 0 === options.length ){ 
                            more = false; 
                        }
						return {
							results: options,
                            pagination: {
                                more: more
                            }
						};
					},
				}
			} );
		} );
	}

	function getProductListBasedOnThreeCharAfterUpdate() {
		$( '.fees_pricing_rules .ap_product, ' +
			'.fees_pricing_rules .ap_product_weight, ' +
			'.fees_pricing_rules .ap_product_subtotal' ).each( function() {
			$( '.fees_pricing_rules .ap_product, ' +
				'.fees_pricing_rules .ap_product_weight, ' +
				'.fees_pricing_rules .ap_product_subtotal' ).select2( {
				ajax: {
					url: coditional_vars.ajaxurl,
					dataType: 'json',
					delay: 250,
					data: function( params ) {
						return {
							value: params.term,
							action: 'wcpfc_pro_simple_and_variation_product_list_ajax'
						};
					},
					processResults: function( data ) {
						var options = [];
						if ( data ) {
							$.each( data, function( index, text ) {
								options.push( { id: text[ 0 ], text: allowSpeicalCharacter( text[ 1 ] ) } );
							} );

						}
						return {
							results: options
						};
					},
					cache: true
				},
				minimumInputLength: 3
			} );
		} );
	}

	function numberValidateForAdvanceRules() {
		$( '.number-field' ).keypress( function( e ) {
			var regex = new RegExp( '^[0-9-%.]+$' );
			var str = String.fromCharCode( ! e.charCode ? e.which : e.charCode );
			if ( regex.test( str ) ) {
				return true;
			}
			e.preventDefault();
			return false;
		} );
		$( '.qty-class' ).keypress( function( e ) {
			var regex = new RegExp( '^[0-9]+$' );
			var str = String.fromCharCode( ! e.charCode ? e.which : e.charCode );
			if ( regex.test( str ) ) {
				return true;
			}
			e.preventDefault();
			return false;
		} );
		$( '.weight-class, .price-class' ).keypress( function( e ) {
			var regex = new RegExp( '^[0-9.]+$' );
			var str = String.fromCharCode( ! e.charCode ? e.which : e.charCode );
			if ( regex.test( str ) ) {
				return true;
			}
			e.preventDefault();
			return false;
		} );
	}

	$( window ).load( function() {
		jQuery( '.multiselect2' ).select2();

		$( 'a[href="admin.php?page=wcpfc-pro-list"]' ).parent().addClass( 'current' );
		$( 'a[href="admin.php?page=wcpfc-pro-list"]' ).addClass( 'current' );

		$( '#fee_settings_start_date' ).datepicker( {
			dateFormat: 'dd-mm-yy',
			minDate: '0',
			onSelect: function() {
				var dt = $( this ).datepicker( 'getDate' );
				dt.setDate( dt.getDate() + 1 );
				$( '#fee_settings_end_date' ).datepicker( 'option', 'minDate', dt );
			}
		} );
		$( '#fee_settings_end_date' ).datepicker( {
			dateFormat: 'dd-mm-yy',
			minDate: '0',
			onSelect: function() {
				var dt = $( this ).datepicker( 'getDate' );
				dt.setDate( dt.getDate() - 1 );
				$( '#fee_settings_start_date' ).datepicker( 'option', 'maxDate', dt );
			}
		} );
		var ele = $( '#total_row' ).val();
		var count;
		if ( ele > 2 ) {
			count = ele;
		} else {
			count = 2;
		}
		$( 'body' ).on( 'click', '#fee-add-field', function() {
			var fee_add_field = $( '#tbl-product-fee tbody' ).get( 0 );

			var tr = document.createElement( 'tr' );
			tr = setAllAttributes( tr, { 'id': 'row_' + count } );
			fee_add_field.appendChild( tr );

			// generate td of condition
			var td = document.createElement( 'td' );
			td = setAllAttributes( td, { 'class': 'titledesc th_product_fees_conditions_condition' } );
			tr.appendChild( td );
			var conditions = document.createElement( 'select' );
			conditions = setAllAttributes( conditions, {
				'rel-id': count,
				'id': 'product_fees_conditions_condition_' + count,
				'name': 'fees[product_fees_conditions_condition][]',
				'class': 'product_fees_conditions_condition'
			} );
			conditions = insertOptions( conditions, get_all_condition() );
			td.appendChild( conditions );
			// td ends

			// generate td for equal or no equal to
			td = document.createElement( 'td' );
			td = setAllAttributes( td, { 'class': 'select_condition_for_in_notin' } );
			tr.appendChild( td );
			var conditions_is = document.createElement( 'select' );
			conditions_is = setAllAttributes( conditions_is, {
				'name': 'fees[product_fees_conditions_is][]',
				'class': 'product_fees_conditions_is product_fees_conditions_is_' + count
			} );
			conditions_is = insertOptions( conditions_is, condition_types( false ) );
			td.appendChild( conditions_is );
			// td ends

			// td for condition values
			td = document.createElement( 'td' );
			td = setAllAttributes( td, { 'id': 'column_' + count, 'class': 'condition-value' } );
			tr.appendChild( td );
			condition_values( jQuery( '#product_fees_conditions_condition_' + count ) );

			var condition_key = document.createElement( 'input' );
			condition_key = setAllAttributes( condition_key, {
				'type': 'hidden',
				'name': 'condition_key[value_' + count + '][]',
				'value': '',
			} );
			td.appendChild( condition_key );
			// var conditions_values_index = jQuery( '.product_fees_conditions_values_' + count ).get( 0 );
			jQuery( '.product_fees_conditions_values_' + count ).trigger( 'change' );
			jQuery( '.multiselect2' ).select2();
			// td ends

			// td for delete button
			td = document.createElement( 'td' );
			tr.appendChild( td );
			var delete_button = document.createElement( 'a' );
			delete_button = setAllAttributes( delete_button, {
				'id': 'fee-delete-field',
				'rel-id': count,
				'title': coditional_vars.delete,
				'class': 'delete-row',
				'href': 'javascript:;'
			} );
			var deleteicon = document.createElement( 'i' );
			deleteicon = setAllAttributes( deleteicon, {
				'class': 'fa fa-trash'
			} );
			delete_button.appendChild( deleteicon );
			td.appendChild( delete_button );
			// td ends

			count ++;
		} );

		function insertOptions( parentElement, options ) {
			var option;
			for ( var i = 0; i < options.length; i ++ ) {
				if ( options[ i ].type === 'optgroup' ) {
					var optgroup = document.createElement( 'optgroup' );
					optgroup = setAllAttributes( optgroup, options[ i ].attributes );
					for ( var j = 0; j < options[ i ].options.length; j ++ ) {
						option = document.createElement( 'option' );
						option = setAllAttributes( option, options[ i ].options[ j ].attributes );
						option.textContent = options[ i ].options[ j ].name;
						optgroup.appendChild( option );
					}
					parentElement.appendChild( optgroup );
				} else {
					option = document.createElement( 'option' );
					option = setAllAttributes( option, options[ i ].attributes );
					option.textContent = allowSpeicalCharacter( options[ i ].name );
					parentElement.appendChild( option );
				}

			}
			return parentElement;

		}

		function allowSpeicalCharacter( str ) {
			return str.replace( '&#8211;', '–' ).replace( '&gt;', '>' ).replace( '&lt;', '<' ).replace( '&#197;', 'Å' );
		}

		function get_all_condition() {
			return [
				{
					'type': 'optgroup',
					'attributes': { 'label': coditional_vars.location_specific },
					'options': [
						{ 'name': coditional_vars.country, 'attributes': { 'value': 'country' } },
						{ 'name': coditional_vars.city, 'attributes': { 'value': 'city' } },
						/* <fs_premium_only> */
						{ 'name': coditional_vars.state, 'attributes': { 'value': 'state' } },
						{ 'name': coditional_vars.postcode, 'attributes': { 'value': 'postcode' } },
						{ 'name': coditional_vars.zone, 'attributes': { 'value': 'zone' } },
						/* </fs_premium_only> */
					]
				},
				{
					'type': 'optgroup',
					'attributes': { 'label': coditional_vars.product_specific },
					'options': [
						{ 'name': coditional_vars.cart_contains_product, 'attributes': { 'value': 'product' } },
						{ 'name': coditional_vars.cart_contains_variable_product, 'attributes': { 'value': 'variableproduct' } },
						{ 'name': coditional_vars.cart_contains_category_product, 'attributes': { 'value': 'category' } },
						{ 'name': coditional_vars.cart_contains_tag_product, 'attributes': { 'value': 'tag' } },
						{ 'name': coditional_vars.cart_contains_product_qty, 'attributes': { 'value': 'product_qty' } },
					]
				},
                /* <fs_premium_only> */
				{
					'type': 'optgroup',
					'attributes': { 'label': coditional_vars.attribute_specific },
					'options': JSON.parse(coditional_vars.attribute_list)
				},
				/* </fs_premium_only> */
				{
					'type': 'optgroup',
					'attributes': { 'label': coditional_vars.user_specific },
					'options': [
						{ 'name': coditional_vars.user, 'attributes': { 'value': 'user' } },
						/* <fs_premium_only> */
						{ 'name': coditional_vars.user_role, 'attributes': { 'value': 'user_role' } }
						/* </fs_premium_only> */
					]
				},
				{
					'type': 'optgroup',
					'attributes': { 'label': coditional_vars.cart_specific },
					'options': [
						{ 'name': coditional_vars.cart_subtotal_before_discount, 'attributes': { 'value': 'cart_total' } },
						/* <fs_premium_only> */
						{ 'name': coditional_vars.cart_subtotal_after_discount, 'attributes': { 'value': 'cart_totalafter' } },
						{ 'name': coditional_vars.cart_subtotal_specific_products, 'attributes': { 'value': 'cart_specificproduct' } },
						/* </fs_premium_only> */
						{ 'name': coditional_vars.quantity, 'attributes': { 'value': 'quantity' } },
						/* <fs_premium_only> */
						{ 'name': coditional_vars.weight, 'attributes': { 'value': 'weight' } },
						{ 'name': coditional_vars.coupon, 'attributes': { 'value': 'coupon' } },
						{ 'name': coditional_vars.shipping_class, 'attributes': { 'value': 'shipping_class' } }
						/* </fs_premium_only> */
					]
				},
				/* <fs_premium_only> */
				{
					'type': 'optgroup',
					'attributes': { 'label': coditional_vars.payment_specific },
					'options': [
						{ 'name': coditional_vars.payment_gateway, 'attributes': { 'value': 'payment' } },
					]
				},
				{
					'type': 'optgroup',
					'attributes': { 'label': coditional_vars.shipping_specific },
					'options': [
						{ 'name': coditional_vars.shipping_method, 'attributes': { 'value': 'shipping_method' } },
					]
				}
				/* </fs_premium_only> */

			];
		}

		$( '#fee_settings_select_fee_type' ).change( function() {
			if ( jQuery( this ).val() === 'fixed' ) {
				jQuery( '#fee_settings_product_cost' ).attr('type', 'text');
				jQuery( '#fee_settings_product_cost' ).attr( 'placeholder', coditional_vars.currency_symbol );
				jQuery( '.fees_on_cart_total_wrap' ).hide();
			} else if ( jQuery( this ).val() === 'percentage' ) {
				jQuery( '#fee_settings_product_cost' ).attr('type', 'number');
				jQuery( '#fee_settings_product_cost' ).attr( 'placeholder', '%' );
				jQuery( '#fee_settings_product_cost' ).attr( 'step', '0.01' );
				jQuery( '.fees_on_cart_total_wrap' ).show();
			}
			jQuery( '#fee_settings_product_cost' ).val('');
		} );
		if( $( '#fee_settings_select_fee_type' ).val() === 'fixed' ){
			jQuery( '.fees_on_cart_total_wrap' ).hide();
		} else if( $( '#fee_settings_select_fee_type' ).val() === 'percentage' ) {
			jQuery( '.fees_on_cart_total_wrap' ).show();
		}

		$( 'body' ).on( 'change', '.product_fees_conditions_condition', function() {
			condition_values( this );
		} );

		function condition_values( element ) {
			var posts_per_page = 3; // Post per page
			var page = 0; // What page we are on.
			var condition = $( element ).val();
			var count = $( element ).attr( 'rel-id' );
			var column = jQuery( '#column_' + count ).get( 0 );
			jQuery( column ).empty();
			var loader = document.createElement( 'img' );
			loader = setAllAttributes( loader, { 'src': coditional_vars.plugin_url + 'images/ajax-loader.gif' } );
			column.appendChild( loader );
            
			$.ajax( {
				type: 'GET',
				url: coditional_vars.ajaxurl,
				data: {
					'action': 'wcpfc_pro_product_fees_conditions_values_ajax',
					'wcpfc_pro_product_fees_conditions_values_ajax': $( '#wcpfc_pro_product_fees_conditions_values_ajax' ).val(),
					'condition': condition,
					'count': count,
					'posts_per_page': posts_per_page,
					'offset': (page * posts_per_page),
				},
				contentType: 'application/json',
				success: function( response ) {
					page ++;
					var condition_values;
					jQuery( '.product_fees_conditions_is_' + count ).empty();
					var column = jQuery( '#column_' + count ).get( 0 );
					var condition_is = jQuery( '.product_fees_conditions_is_' + count ).get( 0 );
					if ( condition === 'cart_total'
						|| condition === 'quantity'
						|| condition === 'product_qty'
						/* <fs_premium_only> */
						|| condition === 'cart_totalafter'
						|| condition === 'cart_specificproduct'
						|| condition === 'weight'
						/* </fs_premium_only> */
					) {
						condition_is = insertOptions( condition_is, condition_types( true ) );
					} else {
						condition_is = insertOptions( condition_is, condition_types( false ) );
					}
					jQuery( '.product_fees_conditions_is_' + count ).trigger( 'change' );
					jQuery( column ).empty();

					var condition_values_id = '';
					var extra_class = '';
					if ( condition === 'product' ) {
						condition_values_id = 'product-filter-' + count;
						extra_class = 'product_fees_conditions_values_product';
					}
					if ( condition === 'variableproduct' ) {
						condition_values_id = 'var-product-filter-' + count;
						extra_class = 'product_fees_conditions_values_var_product';
					}
					if ( condition === 'product_qty' ) {
						condition_values_id = 'product-qry-filter-' + count;
						extra_class = 'product_fees_conditions_values_product_qty';
					}

					if ( isJson( response ) ) {
						condition_values = document.createElement( 'select' );
						condition_values = setAllAttributes( condition_values, {
							'name': 'fees[product_fees_conditions_values][value_' + count + '][]',
							'class': 'wcpfc_select product_fees_conditions_values product_fees_conditions_values_' + count + ' multiselect2 ' + extra_class,
							'multiple': 'multiple',
							'id': condition_values_id
						} );
						column.appendChild( condition_values );
						var data = JSON.parse( response );
						condition_values = insertOptions( condition_values, data );
					} else {
						var input_extra_class;
						if ( condition === 'quantity' ) {
							input_extra_class = ' qty-class';
						}
						if ( condition === 'weight' ) {
							input_extra_class = ' weight-class';
						}
						if ( condition === 'cart_total' || condition === 'cart_totalafter' || condition === 'product_qty' || condition === 'cart_specificproduct' ) {
							input_extra_class = ' price-class';
						}

						condition_values = document.createElement( jQuery.trim( response ) );
						condition_values = setAllAttributes( condition_values, {
							'name': 'fees[product_fees_conditions_values][value_' + count + ']',
							'class': 'product_fees_conditions_values' + input_extra_class,
							'type': 'text',

						} );
						column.appendChild( condition_values );
					}
					column = $( '#column_' + count ).get( 0 );
					var input_node = document.createElement( 'input' );
					input_node = setAllAttributes( input_node, {
						'type': 'hidden',
						'name': 'condition_key[value_' + count + '][]',
						'value': ''
					} );
					column.appendChild( input_node );
					var p_node, b_node, b_text_node, text_node;
					/* <fs_premium_only> */
					if ( condition === 'product'
						|| condition === 'category'
						|| condition === 'weight'
						|| condition === 'cart_totalafter'
						|| condition === 'cart_specificproduct'
						|| condition === 'product_qty'
					) {
						p_node = document.createElement( 'p' );
						b_node = document.createElement( 'b' );
						b_node = setAllAttributes( b_node, {
							'style': 'color: red;',
						} );
						b_text_node = document.createTextNode( coditional_vars.note );
						b_node.appendChild( b_text_node );
						
						if ( condition === 'product' ) {
							text_node = document.createTextNode( coditional_vars.cart_contains_product_msg );
						}
						if ( condition === 'category' ) {
							text_node = document.createTextNode( coditional_vars.cart_contains_category_msg );
						}
						if ( condition === 'cart_totalafter' ) {
							text_node = document.createTextNode( coditional_vars.cart_subtotal_after_discount_msg );
						}
						if ( condition === 'cart_specificproduct' ) {
							text_node = document.createTextNode( coditional_vars.cart_subtotal_specific_products_msg );
						}
						if ( condition === 'weight' ) {
							text_node = document.createTextNode( coditional_vars.weight_msg );
						}
						if ( condition === 'product_qty' ) {
							text_node = document.createTextNode( coditional_vars.product_qty_msg );
						}
						var a_node = document.createElement( 'a' );
						a_node = setAllAttributes( a_node, {
							'href': coditional_vars.doc_url,
							'target': '_blank'
						} );

						var a_text_node = document.createTextNode( coditional_vars.click_here );
						a_node.appendChild( a_text_node );
						p_node.appendChild( b_node );
						p_node.appendChild( text_node );
						p_node.appendChild( a_node );
						column.appendChild( p_node );
					}
					/* </fs_premium_only> */
					if( condition === 'city' ){
						p_node = document.createElement( 'p' );
						b_node = document.createElement( 'b' );
						b_node = setAllAttributes( b_node, {
							'style': 'color: red;',
						} );
						b_text_node = document.createTextNode( coditional_vars.note );
						b_node.appendChild( b_text_node );

						if ( condition === 'city' ) {
							text_node = document.createTextNode( coditional_vars.city_msg );
						}
						p_node.appendChild( b_node );
						p_node.appendChild( text_node );
						column.appendChild( p_node );
					}

					jQuery( '.multiselect2' ).select2();

					productFilter();

					
					varproductFilter();
					getProductListBasedOnThreeCharAfterUpdate();
					
					numberValidateForAdvanceRules();
				}
			} );
		}

		function condition_types( text ) {
			if ( text === true ) {
				return [
					{ 'name': coditional_vars.equal_to, 'attributes': { 'value': 'is_equal_to' } },
					{ 'name': coditional_vars.less_or_equal_to, 'attributes': { 'value': 'less_equal_to' } },
					{ 'name': coditional_vars.less_than, 'attributes': { 'value': 'less_then' } },
					{ 'name': coditional_vars.greater_or_equal_to, 'attributes': { 'value': 'greater_equal_to' } },
					{ 'name': coditional_vars.greater_than, 'attributes': { 'value': 'greater_then' } },
					{ 'name': coditional_vars.not_equal_to, 'attributes': { 'value': 'not_in' } },
				];
			} else {
				return [
					{ 'name': coditional_vars.equal_to, 'attributes': { 'value': 'is_equal_to' } },
					{ 'name': coditional_vars.not_equal_to, 'attributes': { 'value': 'not_in' } },
				];

			}

		}

		function isJson( str ) {
			try {
				JSON.parse( str );
			} catch ( err ) {
				return false;
			}
			return true;
		}

		productFilter();

		/* <fs_premium_only> */
		varproductFilter();
		/* </fs_premium_only> */

		$( 'body' ).on( 'click', '.condition-check-all', function() {
			$( 'input.multiple_delete_fee:checkbox' ).not( this ).prop( 'checked', this.checked );
		} );

		$( 'body' ).on( 'click', '#detete-conditional-fee', function() {
			if ( $( '.multiple_delete_fee:checkbox:checked' ).length === 0 ) {
				alert( coditional_vars.select_atleast_one_checkbox );
				return false;
			}
			if ( confirm( coditional_vars.delete_confirmation_msg ) ) {
				var allVals = [];
				$( '.multiple_delete_fee:checked' ).each( function() {
					allVals.push( $( this ).val() );
				} );
				$.ajax( {
					type: 'GET',
					url: coditional_vars.ajaxurl,
					data: {
						'action': 'wcpfc_pro_wc_multiple_delete_conditional_fee',
						'nonce': coditional_vars.dsm_ajax_nonce,
						'allVals': allVals
					},
					success: function( response ) {
						alert( response );
						$( '.multiple_delete_fee' ).prop( 'checked', false );
						location.reload();
					}
				} );
			}
		} );

		$( '.disable-enable-conditional-fee' ).click( function() {
			if ( $( '.multiple_delete_fee:checkbox:checked' ).length === 0 ) {
				alert( coditional_vars.select_chk );
				return false;
			}
			if ( confirm( coditional_vars.change_status ) ) {
				var allVals = [];
				$( '.multiple_delete_fee:checked' ).each( function() {
					allVals.push( $( this ).val() );
				} );

				$.ajax( {
					type: 'GET',
					url: coditional_vars.ajaxurl,
					data: {
						'action': 'wcpfc_pro_wc_disable_conditional_fee',
						'nonce': coditional_vars.disable_fees_ajax_nonce,
						'do_action': $( this ).attr( 'id' ),
						'allVals': allVals
					},
					success: function( response ) {
						alert( response );
						$( '.multiple_delete_fee' ).prop( 'checked', false );
						location.reload();
					}
				} );
			}
		} );
		/* description toggle */
		$( 'span.woocommerce_conditional_product_fees_checkout_tab_description' ).click( function( event ) {
			event.preventDefault();
			$( this ).next( 'p.description' ).toggle();
		} );

        var fixHelperModified = function( e, tr ) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each( function( index ) {
                $( this ).width( $originals.eq( index ).width() );
            } );
            return $helper;
        };
        //Make diagnosis table sortable
        $( '.wcpfc-main-table table.wp-list-table tbody' ).sortable( {
            helper: fixHelperModified,
            stop: function() {
                $('.wcpfc-main-table').block({
                    message: null,
                    overlayCSS: {
                        background: 'rgb(255, 255, 255)',
                        opacity: 0.6,
                    },
                });
                var listing = [];
                var paged = jQuery('.current-page').val();
                jQuery( '.ui-sortable-handle' ).each(function() {
                    listing.push(jQuery( this ).find( 'input' ).val());
                });
                $.ajax( {
                    type: 'POST',
                    url: coditional_vars.ajaxurl,
                    // contentType: 'application/json',
                    data: {
                        'action': 'wcpfc_pro_product_fees_conditions_sorting',
                        'sorting_conditional_fee': jQuery( '#sorting_conditional_fee' ).val(),
                        'listing': listing,
                        'paged': paged
                    },
                    success: function( response ) {
                        jQuery('.wcpfc-main-table').unblock();
                        var div_wrap = $('<div></div>').addClass('notice notice-success');
                        var p_text = $('<p></p>').text(response.data.message);
                        div_wrap.append(p_text);
                        // $(div_wrap).insertAfter($('.search-box'));
                        $('.wcpfc-main-table').prepend(div_wrap);
                        setTimeout( function(){
                            div_wrap.remove();
                        }, 2000 );
                    }
                } );

            }
        } );
        $( '.wcpfc-main-table table.wp-list-table tbody' ).disableSelection();
		
		if( $( '#ds_time_from' ).length || $( '#ds_time_to' ).length ){
			var ds_time_from = $( '#ds_time_from' ).val();
			var ds_time_to = $( '#ds_time_to' ).val();
			$( '#ds_time_from' ).timepicker({
				timeFormat: 'h:mm p',
				interval: 30,
				minTime: '00:00 AM',
				maxTime: '11:59 PM',
				startTime: ds_time_from,
				dynamic: true,
				dropdown: true,
				scrollbar: true,
				change: function () {
					var newTime = $(this).val();					
					$( '#ds_time_to' ).timepicker( 'option', 'minTime', newTime );
				}
			});
			
			$('#ds_time_to').timepicker({
				timeFormat: 'h:mm p',
				interval: 30,
				minTime: '00:00AM',
				maxTime: '11:59PM',
				startTime: ds_time_to,
				dynamic: true,
				dropdown: true,
				scrollbar: true
			});
		}
		jQuery( '.ds_reset_time' ).click(function(){
			$( '#ds_time_from' ).val('');
			$( '#ds_time_to' ).val('');
		});
		/* <fs_premium_only> */

		/* Apply per quantity conditions start */
		if ( $( '#fee_chk_qty_price' ).is( ':checked' ) ) {
			$( '.wcpfc-main-table .product_cost_right_div .applyperqty-boxtwo' ).show();
			$( '.wcpfc-main-table .product_cost_right_div .applyperqty-boxthree' ).show();
			$( '#extra_product_cost' ).prop( 'required', true );
			advancePricingRulesStatus( 'true' );
		} else {
			$( '.wcpfc-main-table .product_cost_right_div .applyperqty-boxtwo' ).hide();
			$( '.wcpfc-main-table .product_cost_right_div .applyperqty-boxthree' ).hide();
			$( '#extra_product_cost' ).prop( 'required', false );
			advancePricingRulesStatus( 'false' );
		}
		$( document ).on( 'change', '#fee_chk_qty_price', function() {
			if ( this.checked ) {
				$( '.wcpfc-main-table .product_cost_right_div .applyperqty-boxtwo' ).show();
				$( '.wcpfc-main-table .product_cost_right_div .applyperqty-boxthree' ).show();
				$( '#extra_product_cost' ).prop( 'required', true );
				advancePricingRulesStatus( 'true' );
			} else {
				$( '.wcpfc-main-table .product_cost_right_div .applyperqty-boxtwo' ).hide();
				$( '.wcpfc-main-table .product_cost_right_div .applyperqty-boxthree' ).hide();
				$( '#extra_product_cost' ).prop( 'required', false );
				advancePricingRulesStatus( 'false' );
			}
		} );
		/* Apply per quantity conditions end */
		/* Add AP Product functionality start */
		//get total count row from hidden field
		var row_product_ele = $( '#total_row_product' ).val();
		var count_product;
		if ( row_product_ele > 2 ) {
			count_product = row_product_ele;
		} else {
			count_product = 2;
		}

		//on click add rule create new method row
		$( 'body' ).on( 'click', '#ap-product-add-field', function() {
			//design new format of advanced pricing method row html
			createAdvancePricingRulesField( 'select', 'qty', 'product', count_product, 'prd', '' );
			getProductListBasedOnThreeCharAfterUpdate();
			numberValidateForAdvanceRules();
			is_percent_valid();//bind percent on blur event for checking the amount is proper format or not
			count_product ++;
		} );
		/* Add AP Product functionality end here */

		/* Apply per product subtotal conditions end */
		/* Add AP product subtotal functionality start */
		//get total count row from hidden field
		var row_total_row_product_subtotal_ele = $( '#total_row_product_subtotal' ).val();
		var count_product_subtotal;
		if ( row_total_row_product_subtotal_ele > 2 ) {
			count_product_subtotal = row_product_ele;
		} else {
			count_product_subtotal = 2;
		}

		//on click add rule create new method row
		$( 'body' ).on( 'click', '#ap-product-subtotal-add-field', function() {
			//design new format of advanced pricing method row html
			createAdvancePricingRulesField( 'select', 'subtotal', 'product_subtotal', count_product_subtotal, 'product_subtotal', '' );
			getProductListBasedOnThreeCharAfterUpdate();
			numberValidateForAdvanceRules();
			is_percent_valid();//bind percent on blur event for checking the amount is proper format or not
			count_product_subtotal ++;
		} );

		//get total count row from hidden field for Product Weight
		var count_product_weight_ele = $( '#total_row_product_weight' ).val();
		var count_product_weight;
		if ( count_product_weight_ele > 2 ) {
			count_product_weight = count_product_weight_ele;
		} else {
			count_product_weight = 2;
		}
		//on click add rule create new method row for Product Weight
		$( 'body' ).on( 'click', '#ap-product-weight-add-field', function() {
			createAdvancePricingRulesField( 'select', 'weight', 'product_weight', count_product_weight, 'product_weight', '' );
			numberValidateForAdvanceRules();
			getProductListBasedOnThreeCharAfterUpdate();
			is_percent_valid();//bind percent on blur event for checking the amount is proper format or not
			count_product_weight ++;
		} );

		/* Add AP Category functionality start here*/

		//get total count row from hidden field
		var row_category_ele = $( '#total_row_category' ).val();
		var row_category_count;
		if ( row_category_ele > 2 ) {
			row_category_count = row_category_ele;
		} else {
			row_category_count = 2;
		}
		//on click add rule create new method row
		$( 'body' ).on( 'click', '#ap-category-add-field', function() {
			createAdvancePricingRulesField( 'select', 'qty', 'category', row_category_count, 'cat', 'category_list' );
			jQuery( '.ap_category' ).select2();
			numberValidateForAdvanceRules();
			//set default category list to newly added category dropdown
			//rebide the new row with validation
			is_percent_valid();//bind percent on blur event for checking the amount is proper format or not
			row_category_count ++;
		} );

		/* Add AP Category subtotal functionality start here*/
		//get total count row from hidden field
		var row_category_subtotal_ele = $( '#total_row_category_subtotal' ).val();
		var row_category_subtotal_count;
		if ( row_category_subtotal_ele > 2 ) {
			row_category_subtotal_count = row_category_subtotal_ele;
		} else {
			row_category_subtotal_count = 2;
		}
		//on click add rule create new method row
		$( 'body' ).on( 'click', '#ap-category-subtotal-add-field', function() {
			createAdvancePricingRulesField( 'select', 'subtotal', 'category_subtotal', row_category_subtotal_count, 'category_subtotal', 'category_list' );
			jQuery( '.ap_category_subtotal' ).select2();
			//set default category list to newly added category dropdown
			numberValidateForAdvanceRules();
			// jQuery('#ap_category_fees_conditions_condition_' + count).trigger("chosen:updated");
			//rebide the new row with validation
			is_percent_valid();//bind percent on blur event for checking the amount is proper format or not
			row_category_subtotal_count ++;
		} );

		//get total count row from hidden field for Category Weight
		var category_weight_ele = $( '#total_row_category_weight' ).val();
		var category_weight_count;
		if ( category_weight_ele > 2 ) {
			category_weight_count = category_weight_ele;
		} else {
			category_weight_count = 2;
		}
		//on click add rule create new method row for Category Weight
		$( 'body' ).on( 'click', '#ap-category-weight-add-field', function() {
			createAdvancePricingRulesField( 'select', 'weight', 'category_weight', category_weight_count, 'category_weight', 'category_list' );
			jQuery( '.ap_category_weight' ).select2();
			numberValidateForAdvanceRules();
			// jQuery('#ap_category_weight_fees_conditions_condition_' + count).trigger('change');
			//rebide the new row with validation
			is_percent_valid();//bind percent on blur event for checking the amount is proper format or not
			category_weight_count ++;
		} );

		//get total count row from hidden field fro cart qty
		var total_cart_qty_ele = $( '#total_row_total_cart_qty' ).val();
		var total_cart_qty_count;
		if ( total_cart_qty_ele > 2 ) {
			total_cart_qty_count = total_cart_qty_ele;
		} else {
			total_cart_qty_count = 2;
		}
		//on click add rule create new method row for total cart
		$( 'body' ).on( 'click', '#ap-total-cart-qty-add-field', function() {
			createAdvancePricingRulesField( 'label', 'qty', 'total_cart_qty', total_cart_qty_count, 'total_cart_qty', '' );
			numberValidateForAdvanceRules();
			//rebide the new row with validation
			is_percent_valid();//bind percent on blur event for checking the amount is proper format or not
			total_cart_qty_count ++;
		} );

		//get total count row from hidden field fro cart weight
		var total_cart_weight_ele = $( '#total_row_total_cart_weight' ).val();
		var total_cart_weight_count;
		if ( total_cart_weight_ele > 2 ) {
			total_cart_weight_count = total_cart_weight_ele;
		} else {
			total_cart_weight_count = 2;
		}
		//on click add rule create new method row for total cart weight
		$( 'body' ).on( 'click', '#ap-total-cart-weight-add-field', function() {
			createAdvancePricingRulesField( 'label', 'weight', 'total_cart_weight', total_cart_weight_count, 'total_cart_weight', '' );
			numberValidateForAdvanceRules();
			//rebide the new row with validation
			is_percent_valid();//bind percent on blur event for checking the amount is proper format or not
			total_cart_weight_count ++;
		} );
		/* Add AP Category functionality end here */

		//get total count row from hidden field fro cart weight
		var total_cart_subtotal_ele = $( '#total_row_total_cart_subtotal' ).val();
		var total_cart_subtotal_count;
		if ( total_cart_subtotal_ele > 2 ) {
			total_cart_subtotal_count = total_cart_subtotal_ele;
		} else {
			total_cart_subtotal_count = 2;
		}
		//on click add rule create new method row for total cart weight
		$( 'body' ).on( 'click', '#ap-total-cart-subtotal-add-field', function() {
			createAdvancePricingRulesField( 'label', 'subtotal', 'total_cart_subtotal', total_cart_subtotal_count, 'total_cart_subtotal', '' );
			numberValidateForAdvanceRules();
			//rebide the new row with validation
			is_percent_valid();//bind percent on blur event for checking the amount is proper format or not
			total_cart_subtotal_count ++;
		} );

		//get total count row from hidden field fro cart weight
		var shipping_class_subtotal_ele = $( '#total_row_shipping_class_subtotal' ).val();
		var shipping_class_subtotal_count;
		if ( shipping_class_subtotal_ele > 2 ) {
			shipping_class_subtotal_count = shipping_class_subtotal_ele;
		} else {
			shipping_class_subtotal_count = 2;
		}
		//on click add rule create new method row for total cart weight
		$( 'body' ).on( 'click', '#ap-shipping-class-subtotal-add-field', function() {
			createAdvancePricingRulesField( 'select', 'subtotal', 'shipping_class_subtotal', shipping_class_subtotal_count, 'shipping_class_subtotal', 'shipping_class_list' );
			jQuery( '.ap_shipping_class_subtotal' ).select2();
			numberValidateForAdvanceRules();
			//rebide the new row with validation
			is_percent_valid();//bind percent on blur event for checking the amount is proper format or not
			shipping_class_subtotal_count ++;
		} );

		/* Defines AP Rules validate functions */
		function is_percent_valid() {
			//check amount only contains number or percentage
			$( '.percent_only' ).blur( function() {

				//regular expression for the valid amount enter like 20 or 20% or 50.0 or 50.55% etc.. is valid
				var is_valid_percent = /^[-]{0,1}((100)|(\d{1,2}(\.\d{1,2})?))[%]{0,1}$/;
				var percent_val = $( this ).val();
				//check that entered amount for the advanced price is valid or not like 20 or 20% or 50.0 or 50.55% etc.. is valid
				if ( ! is_valid_percent.test( percent_val ) ) {
					$( this ).val( '' );//if percent not in proper format than it will blank the textbox
				}
				//display note that if admin add - price than how message display in shipping method
				var first_char = percent_val.charAt( 0 );
				if ( first_char === '-' ) {
					//remove old notice message if exist
					$( this ).next().remove( 'p' );
					$( this ).after( coditional_vars.warning_msg1 );
				} else {
					//remove notice message if value is possitive
					$( this ).next().remove( 'p' );
				}
			} );
		}

		/* Add AP Category functionality end here */
		getProductListBasedOnThreeCharAfterUpdate();

		//validate Advanced pricing table data
		$( '.wcpfc-main-table input[name="submitFee"]' ).on( 'click', function( e ) {
			// fees_pricing_rules
			var validation_color_code = '#dc3232';
			var default_color_code = '#0085BA';
			var fees_pricing_rules_validation = true;
			var product_based_validation = true;
			var apply_per_qty_validation = true;
			var div;
			if ( $( 'input[name="ap_rule_status"]' ).prop( 'checked' ) === true ) {
				if ( $( '.fees_pricing_rules:visible' ).length !== 0 ) {
					//set flag default to n
					var submit_prd_form_flag = true;
					var submit_prd_flag = false;

					var submit_prd_subtotal_form_flag = true;
					var submit_prd_subtotal_flag = false;

					var submit_cat_form_flag = true;
					var submit_cat_flag = false;

					var submit_cat_subtotal_form_flag = true;
					var submit_cat_subtotal_flag = false;

					var submit_total_cart_qty_form_flag = true;
					var submit_total_cart_qty_flag = false;

					var submit_product_weight_form_flag = true;
					var submit_product_weight_flag = false;

					var submit_category_weight_form_flag = true;
					var submit_category_weight_flag = false;

					var submit_total_cart_weight_form_flag = true;
					var submit_total_cart_weight_flag = false;

					var submit_total_cart_subtotal_form_flag = true;
					var submit_total_cart_subtotal_flag = false;

					var submit_shipping_class_subtotal_form_flag = true;
					var submit_shipping_class_subtotal_flag = false;

					var prd_val_arr = [];
					var prd_subtotal_val_arr = [];
					var cat_val_arr = [];
					var cat_subtotal_val_arr = [];
					var total_cart_qty_val_arr = [];
					var product_weight_val_arr = [];
					var category_weight_val_arr = [];
					var total_cart_weight_val_arr = [];
					var total_cart_subtotal_val_arr = [];
					var shipping_class_subtotal_val_arr = [];

					var no_one_product_row_flag;
					var no_one_product_subtotal_row_flag;
					var no_one_category_row_flag;
					var no_one_category_subtotal_row_flag;
					var no_one_total_cart_qty_row_flag;
					var no_one_product_weight_row_flag;
					var no_one_category_weight_row_flag;
					var no_one_total_cart_weight_row_flag;
					var no_one_total_cart_subtotal_row_flag;
					var no_one_shipping_class_subtotal_row_flag;

					//Start loop each row of AP Product rules
					no_one_product_row_flag = $( '#tbl_ap_product_method tr.ap_product_row_tr' ).length;
					no_one_product_subtotal_row_flag = $( '#tbl_ap_product_subtotal_method tr.ap_product_subtotal_row_tr' ).length;
					no_one_category_row_flag = $( '#tbl_ap_category_method tr.ap_category_row_tr' ).length;
					no_one_category_subtotal_row_flag = $( '#tbl_ap_category_subtotal_method tr.ap_category_subtotal_row_tr' ).length;
					no_one_total_cart_qty_row_flag = $( '#tbl_ap_total_cart_qty_method tr.ap_total_cart_qty_row_tr' ).length;
					no_one_product_weight_row_flag = $( '#tbl_ap_product_weight_method tr.ap_product_weight_row_tr' ).length;
					no_one_category_weight_row_flag = $( '#tbl_ap_category_weight_method tr.ap_category_weight_row_tr' ).length;
					no_one_total_cart_weight_row_flag = $( '#tbl_ap_total_cart_weight_method tr.ap_total_cart_weight_row_tr' ).length;
					no_one_total_cart_subtotal_row_flag = $( '#tbl_ap_total_cart_subtotal_method tr.ap_total_cart_subtotal_row_tr' ).length;
					no_one_shipping_class_subtotal_row_flag = $( '#tbl_ap_shipping_class_subtotal_method tr.ap_shipping_class_subtotal_row_tr' ).length;

					var count_total_tr = no_one_product_row_flag +
						no_one_product_subtotal_row_flag +
						no_one_category_row_flag +
						no_one_category_subtotal_row_flag +
						no_one_total_cart_qty_row_flag +
						no_one_product_weight_row_flag +
						no_one_category_weight_row_flag +
						no_one_total_cart_weight_row_flag +
						no_one_total_cart_subtotal_row_flag +
						no_one_shipping_class_subtotal_row_flag;
						
					var current_tab_id;

					if ( $( '#tbl_ap_product_method tr.ap_product_row_tr' ).length ) {
						$( '#tbl_ap_product_method tr.ap_product_row_tr' ).each( function() {
							//initialize variables
							var min_qty = '',
								max_qty = '';
							var product_id_count = '';
							var product_price = 0;
							var tr_id = jQuery( this ).attr( 'id' );
							var tr_int_id = tr_id.substr( tr_id.lastIndexOf( '_' ) + 1 );
							var max_qty_flag = true;

							//check product empty or not
							if ( jQuery( this ).find( '[name="fees[ap_product_fees_conditions_condition][' + tr_int_id + '][]"]' ).length ) {
								product_id_count = jQuery( this ).find( '[name="fees[ap_product_fees_conditions_condition][' + tr_int_id + '][]"]' ).find( 'option:selected' ).length;
								if ( product_id_count === 0 ) {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '' );
								}
							}
							//check product price empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_price_product][]"]' ).length ) {
								product_price = $( this ).find( '[name="fees[ap_fees_ap_price_product][]"]' ).val();
								if ( product_price === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_product][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_product][]"]' ) ).css( 'border', '' );
								}
							}
							//check if min quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_prd_min_qty][]"]' ).length ) {
								min_qty = $( this ).find( '[name="fees[ap_fees_ap_prd_min_qty][]"]' ).val();
								if ( min_qty === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_prd_min_qty][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_prd_min_qty][]"]' ) ).css( 'border', '' );
								}
							}
							//check if max quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_prd_max_qty][]"]' ).length ) {
								max_qty = $( this ).find( '[name="fees[ap_fees_ap_prd_max_qty][]"]' ).val();
								if ( max_qty !== '' && min_qty !== '' ) {
									max_qty = parseInt( max_qty );
									if ( min_qty > max_qty ) {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_prd_max_qty][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
										max_qty_flag = false;
									} else {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_prd_max_qty][]"]' ) ).css( 'border', '' );
									}
								}
							}

							if ( product_id_count === 0 && min_qty === '' && product_price === '' ) {
								submit_prd_flag = false;
							} else if ( product_id_count === 0 ) {
								submit_prd_flag = false;
							} else if ( min_qty === '' ) {
								submit_prd_flag = false;
							} else if ( max_qty_flag === false ) {
								submit_prd_flag = false;
								displayMsg( 'message_prd_qty', coditional_vars.min_max_qty_error );
							} else if ( product_price === '' ) {
								submit_prd_flag = false;
							} else {
								submit_prd_flag = true;
							}

							prd_val_arr[ tr_int_id ] = submit_prd_flag;

						} );

						if ( prd_val_arr !== '' ) {
							current_tab_id = jQuery( $( '#tbl_ap_product_method tr.ap_product_row_tr' ).parent().parent().parent().parent() ).attr( 'id' );
							if ( jQuery.inArray( false, prd_val_arr ) !== - 1 ) {
								submit_prd_form_flag = false;
								changeColorValidation( current_tab_id, false, validation_color_code );
							} else {
								submit_prd_form_flag = true;
								changeColorValidation( current_tab_id, true, default_color_code );
							}
						}
					}

					if ( $( '#tbl_ap_product_subtotal_method tr.ap_product_subtotal_row_tr' ).length ) {
						$( '#tbl_ap_product_subtotal_method tr.ap_product_subtotal_row_tr' ).each( function() {
							//initialize variables
							var min_qty = '',
								max_qty = '';
							var product_id_count = '';
							var product_price = 0;
							var p_subtotal_tr_id = jQuery( this ).attr( 'id' );
							var p_subtotal_tr_int_id = p_subtotal_tr_id.substr( p_subtotal_tr_id.lastIndexOf( '_' ) + 1 );
							var max_qty_flag = true;

							//check product empty or not
							if ( jQuery( this ).find( '[name="fees[ap_product_subtotal_fees_conditions_condition][' + p_subtotal_tr_int_id + '][]"]' ).length ) {
								product_id_count = jQuery( this ).find( '[name="fees[ap_product_subtotal_fees_conditions_condition][' + p_subtotal_tr_int_id + '][]"]' ).find( 'option:selected' ).length;
								if ( product_id_count === 0 ) {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '' );
								}
							}
							//check product price empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_price_product_subtotal][]"]' ).length ) {
								product_price = $( this ).find( '[name="fees[ap_fees_ap_price_product_subtotal][]"]' ).val();
								if ( product_price === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_product_subtotal][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_product_subtotal][]"]' ) ).css( 'border', '' );
								}
							}
							//check if min quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_product_subtotal_min_subtotal][]"]' ).length ) {
								min_qty = $( this ).find( '[name="fees[ap_fees_ap_product_subtotal_min_subtotal][]"]' ).val();
								if ( min_qty === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_product_subtotal_min_subtotal][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_product_subtotal_min_subtotal][]"]' ) ).css( 'border', '' );
								}
							}
							//check if max quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_product_subtotal_max_subtotal][]"]' ).length ) {
								max_qty = $( this ).find( '[name="fees[ap_fees_ap_product_subtotal_max_subtotal][]"]' ).val();
								if ( max_qty !== '' && min_qty !== '' ) {
									max_qty = parseInt( max_qty );
									if ( min_qty > max_qty ) {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_product_subtotal_max_subtotal][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
										max_qty_flag = false;
									} else {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_product_subtotal_max_subtotal][]"]' ) ).css( 'border', '' );
									}
								}
							}

							if ( product_id_count === 0 && min_qty === '' && product_price === '' ) {
								submit_prd_subtotal_flag = false;
							} else if ( product_id_count === 0 ) {
								submit_prd_subtotal_flag = false;
							} else if ( min_qty === '' ) {
								submit_prd_subtotal_flag = false;
							} else if ( max_qty_flag === false ) {
								submit_prd_subtotal_flag = false;
								displayMsg( 'message_prd_subtotal', coditional_vars.min_max_subtotal_error );
							} else if ( product_price === '' ) {
								submit_prd_subtotal_flag = false;
							} else {
								submit_prd_subtotal_flag = true;
							}

							prd_subtotal_val_arr[ p_subtotal_tr_int_id ] = submit_prd_subtotal_flag;

						} );

						if ( prd_subtotal_val_arr !== '' ) {
							current_tab_id = jQuery( $( '#tbl_ap_product_subtotal_method tr.ap_product_subtotal_row_tr' ).parent().parent().parent().parent() ).attr( 'id' );
							if ( jQuery.inArray( false, prd_subtotal_val_arr ) !== - 1 ) {
								submit_prd_subtotal_form_flag = false;
								changeColorValidation( current_tab_id, false, validation_color_code );
							} else {
								submit_prd_subtotal_form_flag = true;
								changeColorValidation( current_tab_id, true, default_color_code );
							}
						}
					}
					//End loop each row of AP Product rules

					//Start loop each row of AP Category rules
					if ( $( '#tbl_ap_category_method tr.ap_category_row_tr' ).length ) {
						$( '#tbl_ap_category_method tr.ap_category_row_tr' ).each( function() {
							//initialize variables
							var category_id_count = '';
							var cat_product_price = '';
							var min_qty = '',
								max_qty = '';
							var cat_tr_id = jQuery( this ).attr( 'id' );
							var cat_tr_int_id = cat_tr_id.substr( cat_tr_id.lastIndexOf( '_' ) + 1 );
							var max_qty_flag = true;

							//check product empty or not
							if ( $( this ).find( '[name="fees[ap_category_fees_conditions_condition][' + cat_tr_int_id + '][]"]' ).length ) {
								category_id_count = jQuery( this ).find( '[name="fees[ap_category_fees_conditions_condition][' + cat_tr_int_id + '][]"]' ).find( 'option:selected' ).length;
								if ( category_id_count === 0 ) {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '' );
								}
							}
							//check product price empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_price_category][]"]' ).length ) {
								cat_product_price = $( this ).find( '[name="fees[ap_fees_ap_price_category][]"]' ).val();
								if ( cat_product_price === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_category][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_category][]"]' ) ).css( 'border', '' );
								}
							}
							//check if min quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_cat_min_qty][]"]' ).length ) {
								min_qty = $( this ).find( '[name="fees[ap_fees_ap_cat_min_qty][]"]' ).val();
								if ( min_qty === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_cat_min_qty][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_cat_min_qty][]"]' ) ).css( 'border', '' );
								}
							}

							//check if max quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_cat_max_qty][]"]' ).length ) {
								max_qty = $( this ).find( '[name="fees[ap_fees_ap_cat_max_qty][]"]' ).val();
								if ( max_qty !== '' && min_qty !== '' ) {
									max_qty = parseInt( max_qty );
									if ( min_qty > max_qty ) {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_cat_max_qty][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
										max_qty_flag = false;
									} else {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_cat_max_qty][]"]' ) ).css( 'border', '' );
									}
								}
							}

							if ( category_id_count === 0 && min_qty === '' && cat_product_price === '' ) {
								submit_cat_flag = false;
							} else if ( category_id_count === 0 ) {
								submit_cat_flag = false;
							} else if ( min_qty === '' ) {
								submit_cat_flag = false;
							} else if ( max_qty_flag === false ) {
								submit_cat_flag = false;
								displayMsg( 'message_cat_qty', coditional_vars.min_max_qty_error );
							} else if ( cat_product_price === '' ) {
								submit_cat_flag = false;
							} else {
								submit_cat_flag = true;
							}

							cat_val_arr[ cat_tr_int_id ] = submit_cat_flag;

						} );

						if ( cat_val_arr !== '' ) {
							current_tab_id = jQuery( $( '#tbl_ap_category_method tr.ap_category_row_tr' ).parent().parent().parent().parent() ).attr( 'id' );
							if ( jQuery.inArray( false, cat_val_arr ) !== - 1 ) {
								submit_cat_form_flag = false;
								changeColorValidation( current_tab_id, false, validation_color_code );
							} else {
								submit_cat_form_flag = true;
								changeColorValidation( current_tab_id, true, default_color_code );
							}
						}
					}

					if ( $( '#tbl_ap_category_subtotal_method tr.ap_category_subtotal_row_tr' ).length ) {
						$( '#tbl_ap_category_subtotal_method tr.ap_category_subtotal_row_tr' ).each( function() {
							//initialize variables
							var category_id_count = '';
							var cat_product_price = '';
							var min_qty = '',
								max_qty = '';
							var cat_tr_id = jQuery( this ).attr( 'id' );
							var cat_tr_int_id = cat_tr_id.substr( cat_tr_id.lastIndexOf( '_' ) + 1 );
							var max_qty_flag = true;

							//check product empty or not
							if ( $( this ).find( '[name="fees[ap_category_subtotal_fees_conditions_condition][' + cat_tr_int_id + '][]"]' ).length ) {
								category_id_count = jQuery( this ).find( '[name="fees[ap_category_subtotal_fees_conditions_condition][' + cat_tr_int_id + '][]"]' ).find( 'option:selected' ).length;
								if ( category_id_count === 0 ) {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '' );
								}
							}
							//check product price empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_price_category_subtotal][]"]' ).length ) {
								cat_product_price = $( this ).find( '[name="fees[ap_fees_ap_price_category_subtotal][]"]' ).val();
								if ( cat_product_price === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_category_subtotal][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_category_subtotal][]"]' ) ).css( 'border', '' );
								}
							}
							//check if min quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_category_subtotal_min_subtotal][]"]' ).length ) {
								min_qty = $( this ).find( '[name="fees[ap_fees_ap_category_subtotal_min_subtotal][]"]' ).val();
								if ( min_qty === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_category_subtotal_min_subtotal][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_category_subtotal_min_subtotal][]"]' ) ).css( 'border', '' );
								}
							}

							//check if max quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_category_subtotal_max_subtotal][]"]' ).length ) {
								max_qty = $( this ).find( '[name="fees[ap_fees_ap_category_subtotal_max_subtotal][]"]' ).val();
								if ( max_qty !== '' && min_qty !== '' ) {
									max_qty = parseInt( max_qty );
									if ( min_qty > max_qty ) {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_category_subtotal_max_subtotal][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
										max_qty_flag = false;
									} else {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_category_subtotal_max_subtotal][]"]' ) ).css( 'border', '' );
									}
								}
							}

							if ( category_id_count === 0 && min_qty === '' && cat_product_price === '' ) {
								submit_cat_subtotal_flag = false;
							} else if ( category_id_count === 0 ) {
								submit_cat_subtotal_flag = false;
							} else if ( min_qty === '' ) {
								submit_cat_subtotal_flag = false;
							} else if ( max_qty_flag === false ) {
								submit_cat_subtotal_flag = false;
								displayMsg( 'message_cat_qty', coditional_vars.min_max_subtotal_error );
							} else if ( cat_product_price === '' ) {
								submit_cat_subtotal_flag = false;
							} else {
								submit_cat_subtotal_flag = true;
							}

							cat_subtotal_val_arr[ cat_tr_int_id ] = submit_cat_subtotal_flag;

						} );

						if ( cat_subtotal_val_arr !== '' ) {
							current_tab_id = jQuery( $( '#tbl_ap_category_subtotal_method tr.ap_category_subtotal_row_tr' ).parent().parent().parent().parent() ).attr( 'id' );
							if ( jQuery.inArray( false, cat_subtotal_val_arr ) !== - 1 ) {
								submit_cat_subtotal_form_flag = false;
								changeColorValidation( current_tab_id, false, validation_color_code );
							} else {
								submit_cat_subtotal_form_flag = true;
								changeColorValidation( current_tab_id, true, default_color_code );
							}
						}
					}
					//End loop each row of AP Product rules

					//Start loop each row of AP Total Cart QTY rules
					if ( $( '#tbl_ap_total_cart_qty_method tr.ap_total_cart_qty_row_tr' ).length ) {
						$( '#tbl_ap_total_cart_qty_method tr.ap_total_cart_qty_row_tr' ).each( function() {
							//initialize variables
							var total_cart_qty_product_price = '';
							var min_qty = '',
								max_qty = '';
							var total_cart_qty_tr_id = jQuery( this ).attr( 'id' );
							var total_cart_qty_tr_int_id = total_cart_qty_tr_id.substr( total_cart_qty_tr_id.lastIndexOf( '_' ) + 1 );
							var max_qty_flag = true;

							//check product empty or not
							//check product price empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_price_total_cart_qty][]"]' ).length ) {
								total_cart_qty_product_price = $( this ).find( '[name="fees[ap_fees_ap_price_total_cart_qty][]"]' ).val();
								if ( total_cart_qty_product_price === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_total_cart_qty][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_total_cart_qty][]"]' ) ).css( 'border', '' );
								}
							}
							//check if min quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_total_cart_qty_min_qty][]"]' ).length ) {
								min_qty = $( this ).find( '[name="fees[ap_fees_ap_total_cart_qty_min_qty][]"]' ).val();
								if ( min_qty === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_total_cart_qty_min_qty][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_total_cart_qty_min_qty][]"]' ) ).css( 'border', '' );
								}
							}
							//check if max quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_total_cart_qty_max_qty][]"]' ).length ) {
								max_qty = $( this ).find( '[name="fees[ap_fees_ap_total_cart_qty_max_qty][]"]' ).val();
								if ( max_qty !== '' && min_qty !== '' ) {
									max_qty = parseInt( max_qty );
									if ( min_qty > max_qty ) {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_total_cart_qty_max_qty][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
										max_qty_flag = false;
									} else {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_total_cart_qty_max_qty][]"]' ) ).css( 'border', '' );
									}
								}
							}

							//check if both min and max quantity empty than error focus and set prevent submit flag

							if ( min_qty === '' && total_cart_qty_product_price === '' ) {
								submit_total_cart_qty_flag = false;
							} else if ( max_qty_flag === false ) {
								submit_total_cart_qty_flag = false;
								displayMsg( 'message_cart_qty', coditional_vars.min_max_qty_error );
							} else if ( total_cart_qty_product_price === '' ) {
								submit_total_cart_qty_flag = false;
							} else {
								submit_total_cart_qty_flag = true;
							}
							total_cart_qty_val_arr[ total_cart_qty_tr_int_id ] = submit_total_cart_qty_flag;
						} );

						if ( total_cart_qty_val_arr !== '' ) {
							current_tab_id = jQuery( $( '#tbl_ap_total_cart_qty_method tr.ap_total_cart_qty_row_tr' ).parent().parent().parent().parent() ).attr( 'id' );
							if ( jQuery.inArray( false, total_cart_qty_val_arr ) !== - 1 ) {
								submit_total_cart_qty_form_flag = false;
								changeColorValidation( current_tab_id, false, validation_color_code );
							} else {
								submit_total_cart_qty_form_flag = true;
								changeColorValidation( current_tab_id, true, default_color_code );
							}
						}
					}
					//End loop each row of AP Total Cart QTY rules

					//Start loop each row of AP Product Weight rules
					if ( $( '#tbl_ap_product_weight_method tr.ap_product_weight_row_tr' ).length ) {
						$( '#tbl_ap_product_weight_method tr.ap_product_weight_row_tr' ).each( function() {
							//initialize variables
							var product_weight_id = '';
							var product_weight_product_price = '';
							var min_weight = '',
								max_weight;
							var product_weight_tr_id = jQuery( this ).attr( 'id' );
							var product_weight_tr_int_id = product_weight_tr_id.substr( product_weight_tr_id.lastIndexOf( '_' ) + 1 );
							var max_weight_flag = true;

							//check product empty or not
							if ( $( this ).find( '[name="fees[ap_product_weight_fees_conditions_condition][' + product_weight_tr_int_id + '][]"]' ).length ) {
								product_weight_id = jQuery( this ).find( '[name="fees[ap_product_weight_fees_conditions_condition][' + product_weight_tr_int_id + '][]"]' ).find( 'option:selected' ).length;
								if ( product_weight_id === 0 ) {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '1px solid #dc3232' );
								} else {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '' );
								}
							}

							//check product price empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_price_product_weight][]"]' ).length ) {
								product_weight_product_price = $( this ).find( '[name="fees[ap_fees_ap_price_product_weight][]"]' ).val();
								if ( product_weight_product_price === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_product_weight][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_product_weight][]"]' ) ).css( 'border', '' );
								}
							}
							//check if min quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_product_weight_min_weight][]"]' ).length ) {
								min_weight = $( this ).find( '[name="fees[ap_fees_ap_product_weight_min_weight][]"]' ).val();
								if ( min_weight === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_product_weight_min_weight][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_product_weight_min_weight][]"]' ) ).css( 'border', '' );
								}
							}
							//check if max quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_product_weight_max_weight][]"]' ).length ) {
								max_weight = $( this ).find( '[name="fees[ap_fees_ap_product_weight_max_weight][]"]' ).val();
								if ( max_weight !== '' && min_weight !== '' ) {
									max_weight = parseFloat( max_weight );
									if ( min_weight > max_weight ) {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_product_weight_max_weight][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
										max_weight_flag = false;
									} else {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_product_weight_max_weight][]"]' ) ).css( 'border', '' );
									}
								}
							}

							if ( product_weight_id === 0 && min_weight === '' && product_weight_product_price === '' ) {
								submit_product_weight_flag = false;
							} else if ( product_weight_id === 0 ) {
								submit_product_weight_flag = false;
							} else if ( min_weight === '' ) {
								submit_product_weight_flag = false;
							} else if ( max_weight_flag === false ) {
								submit_product_weight_flag = false;
								displayMsg( 'message_prd_weight', coditional_vars.min_max_weight_error );
							} else if ( product_weight_product_price === '' ) {
								submit_product_weight_flag = false;
							} else {
								submit_product_weight_flag = true;
							}

							product_weight_val_arr[ product_weight_tr_int_id ] = submit_product_weight_flag;
						} );

						if ( product_weight_val_arr !== '' ) {
							current_tab_id = jQuery( $( '#tbl_ap_product_weight_method tr.ap_product_weight_row_tr' ).parent().parent().parent().parent() ).attr( 'id' );
							if ( jQuery.inArray( false, product_weight_val_arr ) !== - 1 ) {
								submit_product_weight_form_flag = false;
								changeColorValidation( current_tab_id, false, validation_color_code );
							} else {
								submit_product_weight_form_flag = true;
								changeColorValidation( current_tab_id, true, default_color_code );
							}
						}
					}
					//End loop each row of AP Product Weight rules

					//Start loop each row of AP Category Weight rules
					if ( $( '#tbl_ap_category_weight_method tr.ap_category_weight_row_tr' ).length ) {
						$( '#tbl_ap_category_weight_method tr.ap_category_weight_row_tr' ).each( function() {
							//initialize variables
							var category_weight_id = '';
							var category_weight_product_price = '';
							var min_weight = '',
								max_weight;
							var category_weight_tr_id = jQuery( this ).attr( 'id' );
							var category_weight_tr_int_id = category_weight_tr_id.substr( category_weight_tr_id.lastIndexOf( '_' ) + 1 );
							var max_weight_flag = true;

							//check product empty or not
							if ( $( this ).find( '[name="fees[ap_category_weight_fees_conditions_condition][' + category_weight_tr_int_id + '][]"]' ).length ) {
								category_weight_id = jQuery( this ).find( '[name="fees[ap_category_weight_fees_conditions_condition][' + category_weight_tr_int_id + '][]"]' ).find( 'option:selected' ).length;
								if ( category_weight_id === 0 ) {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '1px solid #dc3232' );
								} else {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '' );
								}
							}

							//check product price empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_price_category_weight][]"]' ).length ) {
								category_weight_product_price = $( this ).find( '[name="fees[ap_fees_ap_price_category_weight][]"]' ).val();
								if ( category_weight_product_price === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_category_weight][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_category_weight][]"]' ) ).css( 'border', '' );
								}
							}
							//check if min quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_category_weight_min_weight][]"]' ).length ) {
								min_weight = $( this ).find( '[name="fees[ap_fees_ap_category_weight_min_weight][]"]' ).val();
								if ( min_weight === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_category_weight_min_weight][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_category_weight_min_weight][]"]' ) ).css( 'border', '' );
								}
							}
							//check if max quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_category_weight_max_weight][]"]' ).length ) {
								max_weight = $( this ).find( '[name="fees[ap_fees_ap_category_weight_max_weight][]"]' ).val();
								if ( max_weight !== '' && min_weight !== '' ) {
									max_weight = parseFloat( max_weight );
									if ( min_weight > max_weight ) {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_category_weight_max_weight][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
										max_weight_flag = false;
									} else {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_category_weight_max_weight][]"]' ) ).css( 'border', '' );
									}
								}
							}

							if ( category_weight_id === 0 && min_weight === '' && category_weight_product_price === '' ) {
								submit_category_weight_flag = false;
							} else if ( category_weight_id === 0 ) {
								submit_category_weight_flag = false;
							} else if ( min_weight === '' ) {
								submit_category_weight_flag = false;
							} else if ( max_weight_flag === false ) {
								submit_category_weight_flag = false;
								displayMsg( 'message_prd_weight', coditional_vars.min_max_weight_error );
							} else if ( category_weight_product_price === '' ) {
								submit_category_weight_flag = false;
							} else {
								submit_category_weight_flag = true;
							}
							category_weight_val_arr[ category_weight_tr_int_id ] = submit_category_weight_flag;
						} );

						if ( category_weight_val_arr !== '' ) {
							current_tab_id = jQuery( $( '#tbl_ap_category_weight_method tr.ap_category_weight_row_tr' ).parent().parent().parent().parent() ).attr( 'id' );
							if ( jQuery.inArray( false, category_weight_val_arr ) !== - 1 ) {
								submit_category_weight_form_flag = false;
								changeColorValidation( current_tab_id, false, validation_color_code );
							} else {
								submit_category_weight_form_flag = true;
								changeColorValidation( current_tab_id, true, default_color_code );
							}
						}
					}
					//End loop each row of AP Category Weight rules

					//Start loop each row of AP Total Cart Weight rules
					if ( $( '#tbl_ap_total_cart_weight_method tr.ap_total_cart_weight_row_tr' ).length ) {
						$( '#tbl_ap_total_cart_weight_method tr.ap_total_cart_weight_row_tr' ).each( function() {
							//initialize variables
							var total_cart_weight_product_price = '';
							var min_weight = '',
								max_weight = '';
							var total_cart_weight_tr_id = jQuery( this ).attr( 'id' );
							var total_cart_weight_tr_int_id = total_cart_weight_tr_id.substr( total_cart_weight_tr_id.lastIndexOf( '_' ) + 1 );
							var max_weight_flag = true;

							//check product empty or not
							//check product price empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_price_total_cart_weight][]"]' ).length ) {
								total_cart_weight_product_price = $( this ).find( '[name="fees[ap_fees_ap_price_total_cart_weight][]"]' ).val();
								if ( total_cart_weight_product_price === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_total_cart_weight][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_total_cart_weight][]"]' ) ).css( 'border', '' );
								}
							}
							//check if min quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_total_cart_weight_min_weight][]"]' ).length ) {
								min_weight = $( this ).find( '[name="fees[ap_fees_ap_total_cart_weight_min_weight][]"]' ).val();
								if ( min_weight === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_total_cart_weight_min_weight][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									min_weight = parseFloat( min_weight );
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_total_cart_weight_min_weight][]"]' ) ).css( 'border', '' );
								}
							}

							//check if max quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_total_cart_weight_max_weight][]"]' ).length ) {
								max_weight = $( this ).find( '[name="fees[ap_fees_ap_total_cart_weight_max_weight][]"]' ).val();
								if ( max_weight !== '' && min_weight !== '' ) {
									max_weight = parseFloat( max_weight );
									if ( min_weight > max_weight ) {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_total_cart_weight_max_weight][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
										max_weight_flag = false;
									} else {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_total_cart_weight_max_weight][]"]' ) ).css( 'border', '' );
									}
								}
							}

							//check if both min and max quantity empty than error focus and set prevent submit flag
							if ( min_weight === '' && total_cart_weight_product_price === '' ) {
								submit_total_cart_weight_flag = false;
							} else if ( max_weight_flag === false ) {
								submit_total_cart_weight_flag = false;
								displayMsg( 'message_cart_weight', coditional_vars.min_max_weight_error );
							} else if ( total_cart_weight_product_price === '' ) {
								submit_total_cart_weight_flag = false;
							} else {
								submit_total_cart_weight_flag = true;
							}

							total_cart_weight_val_arr[ total_cart_weight_tr_int_id ] = submit_total_cart_weight_flag;
						} );

						if ( total_cart_weight_val_arr !== '' ) {
							current_tab_id = jQuery( $( '#tbl_ap_total_cart_weight_method tr.ap_total_cart_weight_row_tr' ).parent().parent().parent().parent() ).attr( 'id' );
							if ( jQuery.inArray( false, total_cart_weight_val_arr ) !== - 1 ) {
								submit_total_cart_weight_form_flag = false;
								changeColorValidation( current_tab_id, false, validation_color_code );
							} else {
								submit_total_cart_weight_form_flag = true;
								changeColorValidation( current_tab_id, true, default_color_code );
							}
						}
					}
					//End loop each row of AP Total Cart Weight rules

					//Start loop each row of AP Total Subcart rules
					if ( $( '#tbl_ap_total_cart_subtotal_method tr.ap_total_cart_subtotal_row_tr' ).length ) {
						$( '#tbl_ap_total_cart_subtotal_method tr.ap_total_cart_subtotal_row_tr' ).each( function() {
							//initialize variables
							var total_cart_subtotal_product_price = '';
							var min_subtotal = '',
								max_subtotal = '';
							var total_cart_subtotal_tr_id = jQuery( this ).attr( 'id' );
							var total_cart_subtotal_tr_int_id = total_cart_subtotal_tr_id.substr( total_cart_subtotal_tr_id.lastIndexOf( '_' ) + 1 );
							// var current_total_cart_subtotal_tab_id = jQuery( $( this ).parent().parent().parent().parent() ).attr( 'id' );
							var max_subtotal_flag = true;

							//check product empty or not
							//check product price empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_price_total_cart_subtotal][]"]' ).length ) {
								total_cart_subtotal_product_price = $( this ).find( '[name="fees[ap_fees_ap_price_total_cart_subtotal][]"]' ).val();
								if ( total_cart_subtotal_product_price === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_total_cart_subtotal][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_total_cart_subtotal][]"]' ) ).css( 'border', '' );
								}
							}
							//check if min quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_total_cart_subtotal_min_subtotal][]"]' ).length ) {
								min_subtotal = $( this ).find( '[name="fees[ap_fees_ap_total_cart_subtotal_min_subtotal][]"]' ).val();
								if ( min_subtotal === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_total_cart_subtotal_min_subtotal][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									min_subtotal = parseFloat( min_subtotal );
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_total_cart_subtotal_min_subtotal][]"]' ) ).css( 'border', '' );
								}
							}

							//check if max quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_total_cart_subtotal_max_subtotal][]"]' ).length ) {
								max_subtotal = $( this ).find( '[name="fees[ap_fees_ap_total_cart_subtotal_max_subtotal][]"]' ).val();
								if ( max_subtotal !== '' && max_subtotal !== '' ) {
									max_subtotal = parseFloat( max_subtotal );
									if ( min_subtotal > max_subtotal ) {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_total_cart_subtotal_max_subtotal][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
										max_subtotal_flag = false;
									} else {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_total_cart_subtotal_max_subtotal][]"]' ) ).css( 'border', '' );
									}
								}
							}

							if ( min_subtotal === '' && total_cart_subtotal_product_price === '' ) {
								submit_total_cart_subtotal_flag = false;
							} else if ( max_subtotal_flag === false ) {
								submit_total_cart_subtotal_flag = false;
								displayMsg( 'message_cart_weight', coditional_vars.min_max_subtotal_error );
							} else if ( total_cart_subtotal_product_price === '' ) {
								submit_total_cart_subtotal_flag = false;
							} else {
								submit_total_cart_subtotal_flag = true;
							}
							total_cart_subtotal_val_arr[ total_cart_subtotal_tr_int_id ] = submit_total_cart_subtotal_flag;
						} );

						if ( total_cart_subtotal_val_arr !== '' ) {
							current_tab_id = jQuery( $( '#tbl_ap_total_cart_subtotal_method tr.ap_total_cart_subtotal_row_tr' ).parent().parent().parent().parent() ).attr( 'id' );
							if ( jQuery.inArray( false, total_cart_subtotal_val_arr ) !== - 1 ) {
								submit_total_cart_subtotal_form_flag = false;
								changeColorValidation( current_tab_id, false, validation_color_code );
							} else {
								submit_total_cart_subtotal_form_flag = true;
								changeColorValidation( current_tab_id, true, default_color_code );
							}
						}
					}
					//End loop each row of AP Total Subcart rules

					//Start loop each row of AP Category Weight rules
					if ( $( '#tbl_ap_shipping_class_subtotal_method tr.ap_shipping_class_subtotal_row_tr' ).length ) {
						$( '#tbl_ap_shipping_class_subtotal_method tr.ap_shipping_class_subtotal_row_tr' ).each( function() {
							//initialize variables
							var shipping_class_subtotal_id = '';
							var shipping_class_subtotal = '';
							var min_subtotal = '',
								max_subtotal;
							var shipping_class_subtotal_tr_id = jQuery( this ).attr( 'id' );
							var shipping_class_subtotal_tr_int_id = shipping_class_subtotal_tr_id.substr( shipping_class_subtotal_tr_id.lastIndexOf( '_' ) + 1 );
							var max_subtotal_flag = true;

							//check product empty or not
							if ( $( this ).find( '[name="fees[ap_shipping_class_subtotal_fees_conditions_condition][' + shipping_class_subtotal_tr_int_id + '][]"]' ).length ) {
								shipping_class_subtotal_id = jQuery( this ).find( '[name="fees[ap_shipping_class_subtotal_fees_conditions_condition][' + shipping_class_subtotal_tr_int_id + '][]"]' ).find( 'option:selected' ).length;
								if ( shipping_class_subtotal_id === 0 ) {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '1px solid #dc3232' );
								} else {
									jQuery( $( this ).find( '.select2-container .selection .select2-selection' ) ).css( 'border', '' );
								}
							}

							//check product price empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_price_shipping_class_subtotal][]"]' ).length ) {
								shipping_class_subtotal = $( this ).find( '[name="fees[ap_fees_ap_price_shipping_class_subtotal][]"]' ).val();
								if ( shipping_class_subtotal === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_shipping_class_subtotal][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_price_shipping_class_subtotal][]"]' ) ).css( 'border', '' );
								}
							}
							//check if min quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_shipping_class_subtotal_min_subtotal][]"]' ).length ) {
								min_subtotal = $( this ).find( '[name="fees[ap_fees_ap_shipping_class_subtotal_min_subtotal][]"]' ).val();
								if ( min_subtotal === '' ) {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_shipping_class_subtotal_min_subtotal][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
								} else {
									jQuery( $( this ).find( '[name="fees[ap_fees_ap_shipping_class_subtotal_min_subtotal][]"]' ) ).css( 'border', '' );
								}
							}
							//check if max quantity empty or not
							if ( $( this ).find( '[name="fees[ap_fees_ap_shipping_class_subtotal_max_subtotal][]"]' ).length ) {
								max_subtotal = $( this ).find( '[name="fees[ap_fees_ap_shipping_class_subtotal_max_subtotal][]"]' ).val();
								if ( max_subtotal !== '' && min_subtotal !== '' ) {
									max_subtotal = parseFloat( max_subtotal );
									if ( min_subtotal > max_subtotal ) {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_shipping_class_subtotal_max_subtotal][]"]' ) ).css( 'border', '1px solid ' + validation_color_code );
										max_subtotal_flag = false;
									} else {
										jQuery( $( this ).find( '[name="fees[ap_fees_ap_shipping_class_subtotal_max_subtotal][]"]' ) ).css( 'border', '' );
									}
								}
							}

							if ( shipping_class_subtotal_id === 0 && min_subtotal === '' && shipping_class_subtotal === '' ) {
								submit_shipping_class_subtotal_flag = false;
							} else if ( shipping_class_subtotal_id === 0 ) {
								submit_shipping_class_subtotal_flag = false;
							} else if ( min_subtotal === '' ) {
								submit_shipping_class_subtotal_flag = false;
							} else if ( max_subtotal_flag === false ) {
								submit_shipping_class_subtotal_flag = false;
								displayMsg( 'message_prd_weight', coditional_vars.min_max_subtotal_error );
							} else if ( shipping_class_subtotal === '' ) {
								submit_shipping_class_subtotal_flag = false;
							} else {
								submit_shipping_class_subtotal_flag = true;
							}
							shipping_class_subtotal_val_arr[ shipping_class_subtotal_tr_int_id ] = submit_shipping_class_subtotal_flag;
						} );

						if ( shipping_class_subtotal_val_arr !== '' ) {
							current_tab_id = jQuery( $( '#tbl_ap_shipping_class_subtotal_method tr.ap_shipping_class_subtotal_row_tr' ).parent().parent().parent().parent() ).attr( 'id' );
							if ( jQuery.inArray( false, shipping_class_subtotal_val_arr ) !== - 1 ) {
								submit_shipping_class_subtotal_form_flag = false;
								changeColorValidation( current_tab_id, false, validation_color_code );
							} else {
								submit_shipping_class_subtotal_form_flag = true;
								changeColorValidation( current_tab_id, true, default_color_code );
							}
						}
					}
					//End loop each row of AP Category Weight rules

					//if error in validation than prevent form submit.
					if ( submit_prd_form_flag === false ||
						submit_prd_subtotal_form_flag === false ||
						submit_cat_form_flag === false ||
						submit_cat_subtotal_form_flag === false ||
						submit_total_cart_qty_form_flag === false ||
						submit_product_weight_form_flag === false ||
						submit_category_weight_form_flag === false ||
						submit_total_cart_weight_form_flag === false ||
						submit_total_cart_subtotal_form_flag === false ||
						submit_shipping_class_subtotal_form_flag === false ) {//if validate error found
						fees_pricing_rules_validation = false;
					} else {
						if ( count_total_tr > 0 ) {
							fees_pricing_rules_validation = true;
						} else {
							div = document.createElement( 'div' );
							div = setAllAttributes( div, {
								'class': 'warning_msg',
								'id': 'warning_msg_1'
							} );
							div.textContent = coditional_vars.warning_msg2;
							$( div ).insertBefore( '.afrsm-section-left .afrsm-main-table' );
							if ( $( '#warning_msg_1' ).length ) {
								$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );
								setTimeout( function() {
									$( '#warning_msg_1' ).remove();
								}, 7000 );
							}
							fees_pricing_rules_validation = false;
						}
					}
				}
			}
			
			if ( $( 'input[name="fee_chk_qty_price"]' ).prop( 'checked' ) === true ) {
				if ( $( '#price_cartqty_based' ).length ) {
					var price_cartqty_based = $( '#price_cartqty_based' ).val();

					if ( price_cartqty_based === 'qty_product_based' ) {
						var product_fees_conditions_conditions = $( 'select[name=\'fees[product_fees_conditions_condition][]\']' )
							.map( function() {return $( this ).val();} ).get();

						switch ( price_cartqty_based ) {
							case 'qty_product_based':
								if ( product_fees_conditions_conditions.indexOf( 'product' ) === - 1 && product_fees_conditions_conditions.indexOf( 'variableproduct' ) === - 1 &&
									product_fees_conditions_conditions.indexOf( 'category' ) === - 1 && product_fees_conditions_conditions.indexOf( 'tag' ) === - 1 ) {
									e.preventDefault();
									product_based_validation = false;
									// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
									if ( $( '#warning_msg_3' ).length < 1 ) {
										div = document.createElement( 'div' );
										div = setAllAttributes( div, {
											'class': 'warning_msg',
											'id': 'warning_msg_3'
										} );
										div.textContent = coditional_vars.warning_msg3;
										$( div ).insertBefore( '.wcpfc-section-left .wcpfc-main-table' );
									}
									if ( $( '#warning_msg_3' ).length ) {
										$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );
										setTimeout( function() {
											$( '#warning_msg_3' ).remove();
										}, 7000 );
									}
								} else {
									product_based_validation = true;
								}
								break;
							case 'qty_cart_based':
								break;
						}
					}
				}
			}

			/*Apply per qty*/
			if ( $( '#fee_chk_qty_price' ).length ) {
				if ( $( 'input[name="fee_chk_qty_price"]' ).prop( 'checked' ) === true ) {
					if ( $( 'input[name="ap_rule_status"]' ).prop( 'checked' ) === true ) {
						apply_per_qty_validation = false;
						// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
						if ( $( '#warning_msg_4' ).length < 1 ) {
							div = document.createElement( 'div' );
							div = setAllAttributes( div, {
								'class': 'warning_msg',
								'id': 'warning_msg_4'
							} );
							div.textContent = coditional_vars.warning_msg4;
							$( div ).insertBefore( '.wcpfc-section-left .wcpfc-main-table' );
						}
						if ( $( '#warning_msg_4' ).length ) {
							$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );
							setTimeout( function() {
								$( '#warning_msg_4' ).remove();
							}, 7000 );
						}
						advancePricingRulesStatus( 'true' );
					}
				} else {
					apply_per_qty_validation = true;
				}
			}

			// console.log( fees_pricing_rules_validation + ' ' + product_based_validation + ' ' + apply_per_qty_validation );
		
			/* Checking product qty validation start */
			var product_qty_fees_conditions_conditions = $('select[name=\'fees[product_fees_conditions_condition][]\']')
				.map(function () {
					return $(this).val();
				}).get();
			if ( -1 !== product_qty_fees_conditions_conditions.indexOf('product_qty') || -1 !== product_qty_fees_conditions_conditions.indexOf('cart_specificproduct') ) {
				if (product_qty_fees_conditions_conditions.indexOf('product') === -1
				    && product_qty_fees_conditions_conditions.indexOf('variableproduct') === -1
				    && product_qty_fees_conditions_conditions.indexOf('category') === -1
				    && product_qty_fees_conditions_conditions.indexOf('tag') === -1
				    && product_qty_fees_conditions_conditions.indexOf('sku') === -1) {
					// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
					if ( $( '#warning_msg_6' ).length < 1 ) {
						div = document.createElement( 'div' );
						div = setAllAttributes( div, {
							'class': 'warning_msg',
							'id': 'warning_msg_6'
						} );
						div.textContent = coditional_vars.warning_msg6;
						$( div ).insertBefore( '.wcpfc-section-left .wcpfc-main-table' );
					}
					if ( $( '#warning_msg_6' ).length ) {
						$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );
						setTimeout( function() {
							$( '#warning_msg_6' ).remove();
						}, 7000 );
					}
					e.preventDefault();
					return false;
				}
			}

			//Time range validation
			var startTime = $('#ds_time_from').val();
			var endTime = $('#ds_time_to').val();
			if( '' !== startTime && '' !== endTime ){
				var diffTime = ( new Date('1970-1-1 ' + endTime) - new Date('1970-1-1 ' + startTime) ) / 1000 / 60 / 60;
				if( diffTime <= 0 ){
					if ( $( '#warning_msg_7' ).length < 1 ) {
						div = document.createElement( 'div' );
						div = setAllAttributes( div, {
							'class': 'warning_msg',
							'id': 'warning_msg_7'
						} );
						div.textContent = coditional_vars.warning_msg7;
						$( div ).insertBefore( '.wcpfc-section-left .wcpfc-main-table' );
					}
					if ( $( '#warning_msg_7' ).length ) {
						$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );
						setTimeout( function() {
							$( '#warning_msg_7' ).remove();
						}, 7000 );
					}
					e.preventDefault();
					return false;
				}
			}
			
			if ( fees_pricing_rules_validation === false || product_based_validation === false || apply_per_qty_validation === false ) {
				if ( $( '#warning_msg_5' ).length < 1 ) {
					div = document.createElement( 'div' );
					div = setAllAttributes( div, {
						'class': 'warning_msg',
						'id': 'warning_msg_5'
					} );
					div.textContent = coditional_vars.warning_msg5;
					$( div ).insertBefore( '.wcpfc-section-left .wcpfc-main-table' );
				}
				if ( $( '#warning_msg_5' ).length ) {
					$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );
					setTimeout( function() {
						$( '#warning_msg_5' ).remove();
					}, 7000 );
				}
				e.preventDefault();
				return false;
			} else {
				if ( jQuery( '.fees-pricing-rules .fees-table' ).is( ':hidden' ) ) {
					jQuery( '.fees-pricing-rules .fees-table tr td input' ).each( function() {
						$( this ).removeAttr( 'required' );
					} );
				}
				return true;
			}
		} );

		function changeColorValidation( current_tab, required, validation_color_code ) {
			if ( required === false ) {
				jQuery( '.fees_pricing_rules ul li[data-tab=' + current_tab + ']' ).css( 'border-top-color', validation_color_code );
				jQuery( '.fees_pricing_rules ul li[data-tab=' + current_tab + ']' ).css( 'box-shadow', 'inset 0 3px 0 ' + validation_color_code );
			} else {
				jQuery( '.fees_pricing_rules ul li[data-tab=' + current_tab + ']' ).css( 'border-top-color', '' );
				jQuery( '.fees_pricing_rules ul li[data-tab=' + current_tab + ']' ).css( 'box-shadow', '' );
			}

		}

		function displayMsg( msg_id, msg_content ) {
			if ( $( '#' + msg_id ).length <= 0 ) {
				var msg_div = document.createElement( 'div' );
				msg_div = setAllAttributes( msg_div, {
					'class': 'warning_msg',
					'id': msg_id
				} );

				msg_div.textContent = msg_content;
				$( msg_div ).insertBefore( '.wcpfc-section-left .wcpfc-main-table' );

				$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );
				setTimeout( function() {
					$( '#' + msg_id ).remove();
				}, 7000 );
			}
		}

		$( 'ul.tabs li' ).click( function() {
			var tab_id = $( this ).attr( 'data-tab' );

			$( 'ul.tabs li' ).removeClass( 'current' );
			$( '.tab-content' ).removeClass( 'current' );

			$( this ).addClass( 'current' );
			$( '#' + tab_id ).addClass( 'current' );
		} );

		/*Start: hide show pricing rules status*/
		function advancePricingRulesStatus( args ) {
			var url_parameters = getUrlVars();
			var current_fees_id = url_parameters.id;
			var current_value = args;
			$.ajax( {
				type: 'GET',
				url: coditional_vars.ajaxurl,
				data: {
					'action': 'wcpfc_pro_change_status_of_advance_pricing_rules__premium_only',
					'current_fees_id': current_fees_id,
					'current_value': current_value
				},
				success: function( response ) {
					if ( 'true' === jQuery.trim( response ) ) {
						$( 'input[name="ap_rule_status"]' ).prop( 'checked', false );
						hideShowPricingRulesBasedOnPricingRuleStatus();
					}
				}
			} );
		}

		hideShowPricingRulesBasedOnPricingRuleStatus();

		function hideShowPricingRulesBasedOnPricingRuleStatus() {
			//alert('test');
			if ( jQuery( 'input[name="ap_rule_status"]' ).prop( 'checked' ) === true ) {
				//alert('test1');
				jQuery( '.fees_pricing_rules' ).show();
			} else if ( jQuery( 'input[name="ap_rule_status"]' ).prop( 'checked' ) === false ) {
				//alert('test2');
				jQuery( '.fees_pricing_rules' ).hide();
			}
		}

		jQuery( 'body' ).on( 'click', 'input[name="ap_rule_status"]', function() {
			if ( jQuery( this ).prop( 'checked' ) === true ) {
				jQuery( '.fees_pricing_rules' ).show();
				jQuery( '.multiselect2' ).select2();
			} else if ( $( this ).prop( 'checked' ) === false ) {
				jQuery( '.fees_pricing_rules' ).hide();
			}
		} );

		/*End: hide show pricing rules status*/

		function createAdvancePricingRulesField( field_type, qty_or_weight, field_title, field_count, field_title2, category_list_option ) {
			var label_text, min_input_placeholder, max_input_placeholder, inpt_class, inpt_type;
			if ( qty_or_weight === 'qty' ) {
				label_text = coditional_vars.cart_qty;
			} else if ( qty_or_weight === 'weight' ) {
				label_text = coditional_vars.cart_weight;
			} else if ( qty_or_weight === 'subtotal' ) {
				label_text = coditional_vars.cart_subtotal;
			}

			if ( qty_or_weight === 'qty' ) {
				min_input_placeholder = coditional_vars.min_quantity;
			} else if ( qty_or_weight === 'weight' ) {
				min_input_placeholder = coditional_vars.min_weight;
			} else if ( qty_or_weight === 'subtotal' ) {
				min_input_placeholder = coditional_vars.min_subtotal;
			}

			if ( qty_or_weight === 'qty' ) {
				max_input_placeholder = coditional_vars.max_quantity;
			} else if ( qty_or_weight === 'weight' ) {
				max_input_placeholder = coditional_vars.max_weight;
			} else if ( qty_or_weight === 'subtotal' ) {
				max_input_placeholder = coditional_vars.max_subtotal;
			}

			if ( qty_or_weight === 'qty' ) {
				inpt_class = 'qty-class';
				inpt_type = 'number';
			} else if ( qty_or_weight === 'weight' ) {
				inpt_class = 'weight-class';
				inpt_type = 'text';
			} else if ( qty_or_weight === 'subtotal' ) {
				inpt_class = 'price-class';
				inpt_type = 'text';
			}
			var tr = document.createElement( 'tr' );
			tr = setAllAttributes( tr, {
				'class': 'ap_' + field_title + '_row_tr',
				'id': 'ap_' + field_title + '_row_' + field_count,
			} );

			var product_td = document.createElement( 'td' );
			if ( field_type === 'select' ) {
				var product_select = document.createElement( 'select' );
				product_select = setAllAttributes( product_select, {
					'rel-id': field_count,
					'id': 'ap_' + field_title + '_fees_conditions_condition_' + field_count,
					'name': 'fees[ap_' + field_title + '_fees_conditions_condition][' + field_count + '][]',
					'class': 'wcpfc_select ap_' + field_title + ' product_fees_conditions_values multiselect2',
					'multiple': 'multiple',
				} );

				product_td.appendChild( product_select );
				var all_category_option, i, option, category_option;
				if ( category_list_option === 'category_list' ) {
					all_category_option = JSON.parse( $( '#all_category_list' ).html() );
					for ( i = 0; i < all_category_option.length; i ++ ) {
						option = document.createElement( 'option' );
						category_option = all_category_option[ i ];
						option.value = category_option.attributes.value;
						option.text = allowSpeicalCharacter( category_option.name );
						product_select.appendChild( option );
					}
				}
				if ( category_list_option === 'shipping_class_list' ) {
					all_category_option = JSON.parse( $( '#all_shipping_class_list' ).html() );
					for ( i = 0; i < all_category_option.length; i ++ ) {
						option = document.createElement( 'option' );
						category_option = all_category_option[ i ];
						option.value = category_option.attributes.value;
						option.text = allowSpeicalCharacter( category_option.name );
						product_select.appendChild( option );
					}
				}
			}
			if ( field_type === 'label' ) {
				var product_label = document.createElement( 'label' );
				var product_label_text = document.createTextNode( label_text );
				product_label = setAllAttributes( product_label, {
					'for': label_text.toLowerCase(),
				} );
				product_label.appendChild( product_label_text );
				product_td.appendChild( product_label );

				var input_hidden = document.createElement( 'input' );
				input_hidden = setAllAttributes( input_hidden, {
					'id': 'ap_' + field_title + '_fees_conditions_condition_' + field_count,
					'type': 'hidden',
					'name': 'fees[ap_' + field_title + '_fees_conditions_condition][' + field_count + '][]',
				} );
				product_td.appendChild( input_hidden );
			}
			tr.appendChild( product_td );

			var min_qty_td = document.createElement( 'td' );
			min_qty_td = setAllAttributes( min_qty_td, {
				'class': 'column_' + field_count + ' condition-value',
			} );
			var min_qty_input = document.createElement( 'input' );
			if ( qty_or_weight === 'qty' ) {
				min_qty_input = setAllAttributes( min_qty_input, {
					'type': inpt_type,
					'id': 'ap_fees_ap_' + field_title2 + '_min_' + qty_or_weight + '[]',
					'name': 'fees[ap_fees_ap_' + field_title2 + '_min_' + qty_or_weight + '][]',
					'class': 'text-class ' + inpt_class,
					'placeholder': min_input_placeholder,
					'value': '',
					'min': '1',
					'required': '1',
				} );
			} else {
				min_qty_input = setAllAttributes( min_qty_input, {
					'type': inpt_type,
					'id': 'ap_fees_ap_' + field_title2 + '_min_' + qty_or_weight + '[]',
					'name': 'fees[ap_fees_ap_' + field_title2 + '_min_' + qty_or_weight + '][]',
					'class': 'text-class ' + inpt_class,
					'placeholder': min_input_placeholder,
					'value': '',
					'required': '1',
				} );
			}
			min_qty_td.appendChild( min_qty_input );
			tr.appendChild( min_qty_td );

			var max_qty_td = document.createElement( 'td' );
			max_qty_td = setAllAttributes( max_qty_td, {
				'class': 'column_' + field_count + ' condition-value',
			} );
			var max_qty_input = document.createElement( 'input' );
			if ( qty_or_weight === 'qty' ) {
				max_qty_input = setAllAttributes( max_qty_input, {
					'type': inpt_type,
					'id': 'ap_fees_ap_' + field_title2 + '_max_' + qty_or_weight + '[]',
					'name': 'fees[ap_fees_ap_' + field_title2 + '_max_' + qty_or_weight + '][]',
					'class': 'text-class ' + inpt_class,
					'placeholder': max_input_placeholder,
					'value': '',
					'min': '1',
				} );
			} else {
				max_qty_input = setAllAttributes( max_qty_input, {
					'type': inpt_type,
					'id': 'ap_fees_ap_' + field_title2 + '_max_' + qty_or_weight + '[]',
					'name': 'fees[ap_fees_ap_' + field_title2 + '_max_' + qty_or_weight + '][]',
					'class': 'text-class ' + inpt_class,
					'placeholder': max_input_placeholder,
					'value': '',
				} );
			}
			max_qty_td.appendChild( max_qty_input );
			tr.appendChild( max_qty_td );

			var price_td = document.createElement( 'td' );
			var price_input = document.createElement( 'input' );
			price_input = setAllAttributes( price_input, {
				'type': 'text',
				'id': 'ap_fees_ap_price_' + field_title + '[]',
				'name': 'fees[ap_fees_ap_price_' + field_title + '][]',
				'class': 'text-class number-field',
				'placeholder': coditional_vars.amount,
				'value': '',
			} );
			price_td.appendChild( price_input );

			if( 'product' === field_title ) {
				var per_product_label = document.createElement( 'label' );
				var per_product_label_text = document.createTextNode( coditional_vars.per_product );
				per_product_label = setAllAttributes( per_product_label, {
					'class': 'ap-label-checkbox',
				} );
				
				var per_product_checkbox = document.createElement( 'input' );
				per_product_checkbox = setAllAttributes( per_product_checkbox, {
					'type': 'checkbox',
					'id': 'ap_fees_ap_per_' + field_title + '[]',
					'name': 'fees[ap_fees_ap_per_' + field_title + '][]',
					'value': 'yes',
				} );
				per_product_label.appendChild( per_product_checkbox );
				per_product_label.appendChild( per_product_label_text );
				price_td.appendChild( per_product_label );
			}
			tr.appendChild( price_td );

			var delete_td = document.createElement( 'td' );
			var delete_a = document.createElement( 'a' );
			delete_a = setAllAttributes( delete_a, {
				'id': 'ap_' + field_title + '_delete_field',
				'rel-id': field_count,
				'title': coditional_vars.delete,
				'class': 'delete-row',
				'href': 'javascript:;'
			} );
			var delete_i = document.createElement( 'i' );
			delete_i = setAllAttributes( delete_i, {
				'class': 'fa fa-trash'
			} );
			delete_a.appendChild( delete_i );
			delete_td.appendChild( delete_a );

			tr.appendChild( delete_td );

			$( '#tbl_ap_' + field_title + '_method tbody tr' ).last().after( tr );
		}

		//Only enable checkbox for percentage value in ap "Cost on Product" tab
		jQuery(document).on('keyup blur', '.number-field', function(){  
			if(jQuery(this).val().indexOf('%') > -1){ 
				jQuery(this).next().find('input[type="checkbox"]').prop('disabled', false);
			} else {
				jQuery(this).next().find('input[type="checkbox"]').prop('checked', false);
				jQuery(this).next().find('input[type="checkbox"]').prop('disabled', true);
			} 
		});
		jQuery('.number-field').each(function(){  
			if(jQuery(this).val().indexOf('%') > -1){ 
				jQuery(this).next().find('input[type="checkbox"]').prop('disabled', false);
			} else {
				jQuery(this).next().find('input[type="checkbox"]').prop('checked', false);
				jQuery(this).next().find('input[type="checkbox"]').prop('disabled', true);
			} 
		});
		jQuery('.ap-label-checkbox input[type="checkbox"]').change(function(){
			if(jQuery(this).prop('checked')){
				jQuery(this).prev().attr('disabled', true);
			} else {
				jQuery(this).prev().attr('disabled', false);
			}
		});
		jQuery('.ap-label-checkbox input[type="checkbox"]').each(function(){
			if(jQuery(this).prop('checked')){
				jQuery(this).prev().attr('disabled', true);
			} else {
				jQuery(this).prev().attr('disabled', false);
			}
		});

		/*Extra Validation*/
		$( '#extra_product_cost, .price-field' ).keypress( function( e ) {
			var regex = new RegExp( '^[0-9.]+$' );
			var str = String.fromCharCode( ! e.charCode ? e.which : e.charCode );
			if ( regex.test( str ) ) {
				return true;
			}
			e.preventDefault();
			return false;
		} );
		/* </fs_premium_only> */

		$( '[id^=fee_settings_product_cost]' ).keypress( validateNumber );

		function validateNumber( event ) {
			/* <fs_premium_only> */
			if( 'fixed' === $('#fee_settings_select_fee_type').val() ){
				return true;
			}
			/* </fs_premium_only> */
			var key = window.event ? event.keyCode : event.which;
			if ( event.keyCode === 8 || event.keyCode === 46 ) {
				return true;
			} else if ( key < 48 || key > 57 ) {
				return false;
			} else if ( key === 45 ) {
				return true;
			} else if ( key === 37 ) {
				return true;
			} else {
				return true;
			}
		}
		numberValidateForAdvanceRules();


		/*Start: Change shipping status form list section*/
		$( document ).on( 'click', '#fees_status_id', function() {
			var current_fees_id = $( this ).attr( 'data-smid' );
			var current_value = $( this ).prop( 'checked' );
            $('.wcpfc-main-table').block({
                message: null,
                overlayCSS: {
                    background: 'rgb(255, 255, 255)',
                    opacity: 0.6,
                },
            });
			$.ajax( {
				type: 'GET',
				url: coditional_vars.ajaxurl,
				data: {
					'action': 'wcpfc_pro_change_status_from_list_section',
					'current_fees_id': current_fees_id,
					'current_value': current_value
				}, beforeSend: function() {
					var div = document.createElement( 'div' );
					div = setAllAttributes( div, {
						'class': 'loader-overlay',
					} );

					var img = document.createElement( 'img' );
					img = setAllAttributes( img, {
						'id': 'before_ajax_id',
						'src': coditional_vars.ajax_icon
					} );

					div.appendChild( img );
					jQuery( '#conditional-fee-listing' ).after( div );
				}, complete: function() {
					jQuery( '.wcpfc-main-table .loader-overlay' ).remove();
                    jQuery('.wcpfc-main-table').unblock();
				}, success: function( response ) {
                    var div_wrap = $('<div></div>').addClass('notice notice-success');
                    var p_text = $('<p></p>').text(jQuery.trim( response ));
                    div_wrap.append(p_text);
                    // $(div_wrap).insertAfter($('.search-box'));
                    $('.wcpfc-main-table').prepend(div_wrap);
                    setTimeout( function(){
                        div_wrap.remove();
                    }, 2000 );
                    jQuery('.wcpfc-main-table').unblock();
				}
			} );
		} );
		/*End: Change shipping status form list section*/

		/*Start: Get last url parameters*/
		function getUrlVars() {
			var vars = [], hash;
			// var get_current_url = coditional_vars.current_url;
			var get_current_url = location.href;
			var hashes = get_current_url.slice( get_current_url.indexOf( '?' ) + 1 ).split( '&' );
			for ( var i = 0; i < hashes.length; i ++ ) {
				hash = hashes[ i ].split( '=' );
				vars.push( hash[ 0 ] );
				vars[ hash[ 0 ] ] = hash[ 1 ];
			}
			return vars;
		}

		/*End: Get last url parameters*/

		function setAllAttributes( element, attributes ) {
			Object.keys( attributes ).forEach( function( key ) {
				element.setAttribute( key, attributes[ key ] );
				// use val
			} );
			return element;
		}

		//remove tr on delete icon click
		$( 'body' ).on( 'click', '.delete-row', function() {
			$( this ).parent().parent().remove();
		} );

		//Save Master Settings
		$( document ).on( 'click', '#save_master_settings', function() {
			var chk_enable_logging;
			var chk_enable_coupon_fee;
			var chk_enable_custom_fun;
			var chk_enable_all_fee_tax;
			var chk_enable_all_fee_tooltip;
			var chk_enable_all_fee_tooltip_text = $('#chk_enable_all_fee_tooltip_text').val();
			var chk_fees_per_page = $('#chk_fees_per_page').val();

			if ( $( '#chk_enable_logging' ).prop( 'checked' ) === true ) {
				chk_enable_logging = 'on';
			} else {
				chk_enable_logging = 'off';
			}
			if ( $( '#chk_enable_coupon_fee' ).prop( 'checked' ) === true ) {
				chk_enable_coupon_fee = 'on';
			} else {
				chk_enable_coupon_fee = 'off';
			}
			if ( $( '#chk_enable_custom_fun' ).prop( 'checked' ) === true ) {
				chk_enable_custom_fun = 'on';
			} else {
				chk_enable_custom_fun = 'off';
			}
			if( chk_enable_all_fee_tooltip_text.length > 25 && 'on' === chk_enable_custom_fun ){
				alert('Please add max 25 character!');
				return;
			}
			if ( $( '#chk_enable_all_fee_tax' ).prop( 'checked' ) === true ) {
				chk_enable_all_fee_tax = 'on';
			} else {
				chk_enable_all_fee_tax = 'off';
			}
			if ( $( '#chk_enable_all_fee_tooltip' ).prop( 'checked' ) === true ) {
				chk_enable_all_fee_tooltip = 'on';
			} else {
				chk_enable_all_fee_tooltip = 'off';
			}

			$.ajax( {
				type: 'GET',
				url: coditional_vars.ajaxurl,
				data: {
					'action': 'wcpfc_pro_save_master_settings',
					'chk_enable_logging': chk_enable_logging,
					'chk_enable_coupon_fee': chk_enable_coupon_fee,
					'chk_enable_custom_fun': chk_enable_custom_fun,
					'chk_enable_all_fee_tax': chk_enable_all_fee_tax,
					'chk_enable_all_fee_tooltip': chk_enable_all_fee_tooltip,
					'chk_enable_all_fee_tooltip_text': chk_enable_all_fee_tooltip_text,
					'chk_fees_per_page': chk_fees_per_page,
				},
				success: function() {
					// var div = document.createElement( 'div' );
					// div = setAllAttributes( div, {
					// 	'class': 'ms-msg'
					// } );
					// div.textContent = coditional_vars.success_msg2;
					// $( div ).insertBefore( '.wcpfc-section-left .wcpfc-main-table' );

                    var div_wrap = $('<div></div>').addClass('notice notice-success');
                    var p_text = $('<p></p>').text(coditional_vars.success_msg2);
                    div_wrap.append(p_text);
                    $('.wcpfc-main-table').prepend(div_wrap);
                    $( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );

					setTimeout( function() {
						div_wrap.remove();
                        window.location.replace(coditional_vars.ajax_redirect_after);
					}, 3000 );
				}
			} );
		} );

		// $( document ).on( 'click', '.conditional-fee-order', function() {
		// 	saveAllIdOrderWise( 'on_click' );
		// } );

		// saveAllIdOrderWise( 'on_load' );

		// /*Start code for save all method as per sequence in list*/
		// function saveAllIdOrderWise( position ) {
		// 	var smOrderArray = [];

		// 	$( 'table#conditional-fee-listing tbody tr' ).each( function() {
		// 		smOrderArray.push( this.id );
		// 	} );
		// 	$.ajax( {
		// 		type: 'GET',
		// 		url: coditional_vars.ajaxurl,
		// 		data: {
		// 			'action': 'wcpfc_pro_sm_sort_order',
		// 			'smOrderArray': smOrderArray
		// 		},
		// 		success: function() {
		// 			if ( 'on_click' === jQuery.trim( position ) ) {
		// 				alert( coditional_vars.success_msg1 );
		// 			}
		// 		}
		// 	} );
		// }

		/*Start: Change shipping status form list section*/
		$( document ).on( 'click', '#shipping_status_id', function() {
			var current_shipping_id = $( this ).attr( 'data-smid' );
			var current_value = $( this ).prop( 'checked' );
			$.ajax( {
				type: 'GET',
				url: coditional_vars.ajaxurl,
				data: {
					'action': 'afrsm_pro_change_status_from_list_section',
					'current_shipping_id': current_shipping_id,
					'current_value': current_value
				}, beforeSend: function() {
					var div = document.createElement( 'div' );
					div = setAllAttributes( div, {
						'class': 'loader-overlay',
					} );

					var img = document.createElement( 'img' );
					img = setAllAttributes( img, {
						'id': 'before_ajax_id',
						'src': coditional_vars.ajax_icon
					} );

					div.appendChild( img );
					jQuery( '#shipping-methods-listing' ).after( div );
				}, complete: function() {
					jQuery( '.afrsm-main-table .loader-overlay' ).remove();
				}, success: function( response ) {
					alert( jQuery.trim( response ) );
				}
			} );
		} );
		/*End: Change shipping status form list section*/

	} );
	jQuery( window ).on( 'load', function() {
		jQuery( '.multiselect2' ).select2();

		jQuery('#ds_select_day_of_week').select2({
			placeholder: 'Select days of the week'
		});

		function allowSpeicalCharacter( str ) {
			return str.replace( '&#8211;', '–' ).replace( '&gt;', '>' ).replace( '&lt;', '<' ).replace( '&#197;', 'Å' );
		}
        productFilter();
		varproductFilter();
		
        /* <fs_premium_only> */
		jQuery( '.fees_pricing_rules .ap_product, ' +
			'.fees_pricing_rules .ap_product_weight, ' +
			'.fees_pricing_rules .ap_product_subtotal' ).each( function() {
			jQuery( '.fees_pricing_rules .ap_product, ' +
				'.fees_pricing_rules .ap_product_weight, ' +
				'.fees_pricing_rules .ap_product_subtotal' ).select2( {
				ajax: {
					url: coditional_vars.ajaxurl,
					dataType: 'json',
					delay: 250,
					data: function( params ) {
						return {
							value: params.term,
							action: 'wcpfc_pro_simple_and_variation_product_list_ajax'
						};
					},
					processResults: function( data ) {
						var options = [];
						if ( data ) {
							jQuery.each( data, function( index, text ) {
								options.push( { id: text[ 0 ], text: allowSpeicalCharacter( text[ 1 ] ) } );
							} );

						}
						return {
							results: options
						};
					},
					cache: true
				},
				minimumInputLength: 3
			} );
		} );
		/* </fs_premium_only> */
	} );
})( jQuery );

jQuery( document ).ready( function() {
	// if ( jQuery( window ).width() <= 980 ) {
		jQuery( '.fees-pricing-rules .fees_pricing_rules .tab-content' ).click( function() {
			var acc_id = jQuery( this ).attr( 'id' );
			jQuery( '.fees-pricing-rules .fees_pricing_rules .tab-content' ).removeClass( 'current' );
			jQuery( '#' + acc_id ).addClass( 'current' );
		} );
	// }
	
    //move notices to top
    // if( jQuery('.notice').length > 0 ) {
    //     setTimeout(function(){
    //         jQuery('.notice').each(function(){
    //             var clone = jQuery('.notice').clone();
    //             jQuery('.notice').remove();
    //             jQuery('.all-pad').prepend(clone);
    //         });
    //     }, 100);
    // }
    // if( jQuery('#message').length > 0 ){
    //     setTimeout(function(){
    //         jQuery('#message').each(function(){
    //             var clone = jQuery('#message').clone();
    //             jQuery('#message').remove();
    //             jQuery('.all-pad').prepend(clone);
    //         });
    //     }, 100);
    // }
    

	/* <fs_premium_only> */
	// Optional fee hide show rules
	function optional_fee_div() {     
		var flag_init = jQuery('#fee_settings_select_optional').val();
		if( 'yes' === flag_init ) {
			jQuery('.enable_optional_checked').show();
			// jQuery('.wcpfc-main-table #fee-add-field, .wcpfc-main-table #general_rule_match, .wcpfc-main-table ul').addClass('disable_me');
			// jQuery('.wcpfc-main-table #tbl-product-fee :input, .wcpfc-main-table #tbl-product-fee a, .wcpfc-main-table #tbl-product-fee  select, .wcpfc-main-table #tbl-product-fee ul, .wcpfc-main-table #tbl-product-fee span').addClass('disable_me');
			// jQuery('.wcpfc-main-table #apm_wrap :input, .wcpfc-main-table #apm_wrap label, .wcpfc-main-table #apm_wrap ul, .wcpfc-main-table #apm_wrap a, .wcpfc-main-table #apm_wrap .slider.round, .wcpfc-main-table #apm_wrap select, .wcpfc-main-table #apm_wrap checkbox').addClass('disable_me');
		} else {
			jQuery('.enable_optional_checked').hide();
			// jQuery('.wcpfc-main-table #fee-add-field, .wcpfc-main-table #general_rule_match, .wcpfc-main-table ul').removeClass('disable_me');
			// jQuery('.wcpfc-main-table #tbl-product-fee :input, .wcpfc-main-table #tbl-product-fee a, .wcpfc-main-table #tbl-product-fee  select, .wcpfc-main-table #tbl-product-fee ul, .wcpfc-main-table #tbl-product-fee span').removeClass('disable_me');
			// jQuery('.wcpfc-main-table #apm_wrap :input, .wcpfc-main-table #apm_wrap label, .wcpfc-main-table #apm_wrap ul, .wcpfc-main-table #apm_wrap a, .wcpfc-main-table #apm_wrap .slider.round, .wcpfc-main-table #apm_wrap select, .wcpfc-main-table #apm_wrap checkbox').removeClass('disable_me');
		}
	}
	
	// use setTimeout() to execute
	setTimeout(optional_fee_div, 1000);
	 
	jQuery(document).on('change', '#fee_settings_select_optional', function () {
		var flag = jQuery(this).val();
		if( 'yes' === flag ) {
			jQuery('.enable_optional_checked').show();
			// jQuery('.wcpfc-main-table #fee-add-field, .wcpfc-main-table #general_rule_match, .wcpfc-main-table ul').addClass('disable_me');
			// jQuery('.wcpfc-main-table #tbl-product-fee :input, .wcpfc-main-table #tbl-product-fee a, .wcpfc-main-table #tbl-product-fee  select, .wcpfc-main-table #tbl-product-fee ul, .wcpfc-main-table #tbl-product-fee span').addClass('disable_me');
			// jQuery('.wcpfc-main-table #apm_wrap :input, .wcpfc-main-table #apm_wrap label, .wcpfc-main-table #apm_wrap ul, .wcpfc-main-table #apm_wrap a, .wcpfc-main-table #apm_wrap .slider.round, .wcpfc-main-table #apm_wrap select, .wcpfc-main-table #apm_wrap checkbox').addClass('disable_me');
		} else {
			jQuery('.enable_optional_checked').hide();
			// jQuery('.wcpfc-main-table #fee-add-field, .wcpfc-main-table #general_rule_match, .wcpfc-main-table ul').removeClass('disable_me');
			// jQuery('.wcpfc-main-table #tbl-product-fee :input, .wcpfc-main-table #tbl-product-fee a, .wcpfc-main-table #tbl-product-fee  select, .wcpfc-main-table #tbl-product-fee ul, .wcpfc-main-table #tbl-product-fee span').removeClass('disable_me');
			// jQuery('.wcpfc-main-table #apm_wrap :input, .wcpfc-main-table #apm_wrap label, .wcpfc-main-table #apm_wrap ul, .wcpfc-main-table #apm_wrap a, .wcpfc-main-table #apm_wrap .slider.round, .wcpfc-main-table #apm_wrap select, .wcpfc-main-table #apm_wrap checkbox').removeClass('disable_me');
		}
	});
	var wcpfcDateFormat = 'mm/dd/yy';
	var from = jQuery( '#wcpfc-custom-from' ).datepicker({
		defaultDate: '+1w',
		dateFormat: wcpfcDateFormat,
		todayHighlight: true,
		maxDate: 0,
		beforeShowDay: function(allDate){
			var toDate = jQuery( '#wcpfc-custom-to' ).val();
			var selectedDate = jQuery(this).val();
			if(toDate.length > 0 ){
				var allMonth = allDate.getMonth()+1;
				allMonth = allMonth > 9 ? allMonth : '0'+allMonth;
				var allYear = allDate.getFullYear();
				var allDay = allDate.getDate();
				allDay = allDay > 9 ? allDay : '0'+allDay;
				var newallDate = toTimestamp( allMonth + '/' + allDay + '/' + allYear );

				if( newallDate === toTimestamp(selectedDate.toString()) ){
					return[true,'firstActive'];
				}
				if( newallDate === toTimestamp(toDate.toString()) ){
					return[true,'lastActive'];
				}
				if( newallDate < toTimestamp(toDate.toString()) && newallDate > toTimestamp(selectedDate.toString()) ){
					return[true,'active'];	
				}
			}
			return[true,'noActive'];
		}
	}).on( 'change', function() {
		to.datepicker( 'option', 'minDate', this.value );
		to.datepicker( 'option', 'maxDate', 0 );
		setTimeout(function(){
            to.datepicker('show');
        }, 16);  
	});
	var to = jQuery( '#wcpfc-custom-to' ).datepicker({
        defaultDate: '+1w',
		dateFormat: wcpfcDateFormat,
		autoclose: false,
		todayHighlight: true,
		beforeShowDay: function(allDate){
			var fromDate = jQuery('#wcpfc-custom-from').val();
			var selectedDate = jQuery(this).val();
			if(fromDate.length > 0 ){
				var allMonth = allDate.getMonth()+1;
				allMonth = allMonth > 9 ? allMonth : '0'+allMonth;
				var allYear = allDate.getFullYear();
				var allDay = allDate.getDate();
				allDay = allDay > 9 ? allDay : '0'+allDay;
				var newallDate = toTimestamp( allMonth + '/' + allDay + '/' + allYear );

				if( newallDate === toTimestamp(selectedDate.toString()) ){
					return[true,'lastActive'];
				}
				if( newallDate === toTimestamp(fromDate.toString()) ){
					return[true,'firstActive'];
				}
				if( newallDate > toTimestamp(fromDate.toString()) && newallDate < toTimestamp(selectedDate.toString()) ){
					return[true,'active'];	
				}
			}
			return[true,'noActive'];
		}
	}).on( 'change', function() {
        from.datepicker( 'option', 'maxDate', 0 );
	});

	function toTimestamp(strDate){ 
		var datum = Date.parse(strDate); 
		return datum/1000;
	}

	//General Chart
	function updateChart(label, data, backgroundColor){
		var ctx = document.getElementById('myChart');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: label,
				datasets: [{
					label: 'Total revenue',
					data: data,
					backgroundColor: backgroundColor,
					barThickness: 50,
				}]
			},
			options: {
				animation:{
					duration: 1000,
				},
				plugins: {
					legend: {
						display: false
					}
				},
				responsive : true,
				maintainAspectRatio: true,
				aspectRatio	: 2
			}
		});
		myChart.update();
	}

	jQuery(document).on('click', '.wcpfc-filter-specific button', function(){
		jQuery('.wcpfc-period-selector #wcpfc-custom-from').val('');
		jQuery('.wcpfc-period-selector #wcpfc-custom-to').val('');
		var $this = jQuery(this);
		var startDate = $this.data('start');
		var endDate = $this.data('end');
		jQuery('.wcpfc-filter-fee').addClass('wcpfc-loader');
		jQuery.ajax({
			url: coditional_vars.ajaxurl,
			type: 'post',
			data: {
				action 	   : 'date_wise_fee_revenue',
				nonce      : coditional_vars.dashboard_ajax_nonce,
				start_date : startDate,
				end_date   : endDate,
			},
			success: function (responce) {

				if(responce.success){
					jQuery('.wcpfc-filter-specific button').removeClass('active');
					//reset chart for new render
					jQuery('#myChart').remove();
  					jQuery('.wcpfc-filter-fee').append('<canvas id="myChart"><canvas>');
					updateChart(responce.label, responce.revenue, responce.backgroundColor);
					$this.addClass('active');
				} else {
					alert(responce.message);
				}
				
				jQuery('.wcpfc-filter-fee').removeClass('wcpfc-loader');
			},
		});
	});
	jQuery('.wcpfc-filter-specific button.all-data').trigger('click');

	jQuery('.wcpfc-period-selector #wcpfc-custom-from, .wcpfc-period-selector #wcpfc-custom-to').on('change', function(){
		var startDate = jQuery('.wcpfc-period-selector #wcpfc-custom-from').val();
		var endDate = jQuery('.wcpfc-period-selector #wcpfc-custom-to').val();
		if( '' !== startDate && '' !== endDate ){
			jQuery('.wcpfc-filter-fee').addClass('wcpfc-loader');
			jQuery.ajax({
				url: coditional_vars.ajaxurl,
				type: 'post',
				data: {
					action 	   : 'date_wise_fee_revenue',
					nonce      : coditional_vars.dashboard_ajax_nonce,
					start_date : startDate,
					end_date   : endDate,
				},
				success: function (responce) {

					if(responce.success){
						jQuery('.wcpfc-filter-specific button').removeClass('active');

						//reset chart for new render
						jQuery('#myChart').remove();
						jQuery('.wcpfc-filter-fee').append('<canvas id="myChart"><canvas>');
						updateChart(responce.label, responce.revenue, responce.backgroundColor);
					} else {
						alert(responce.message);
					}
					
					jQuery('.wcpfc-filter-fee').removeClass('wcpfc-loader');
				},
			});
		}
	});

	if( jQuery('#topFeeChart').length > 0 ){
		jQuery('.wcpfc-top-ten').addClass('wcpfc-loader');
		jQuery.ajax({
			url: coditional_vars.ajaxurl,
			type: 'post',
			data: {
				action : 'top_ten_fees_revenue',
				nonce  : coditional_vars.dashboard_ajax_nonce,
			},
			success: function (responce) {
				if(responce.success){

					jQuery.each(responce.fees_array_list, function(index, fees_list){
						var fee_table_row = jQuery('<div />', { class: 'wcpfc-table-row fee-row-'+index });
						jQuery('.wcpfc-top-ten .wcpfc-table').append(fee_table_row);
						
						jQuery.each(fees_list, function(fee_index, fee_value){
							var fee_table_row_item = jQuery('<div />', { class: 'wcpfc-table-row-item' }).html(fee_value);
							jQuery('.wcpfc-top-ten .wcpfc-table .wcpfc-table-row.fee-row-'+index).append(fee_table_row_item);
						});
					});
					wcpfc_top_ten_fees_chart(responce.fees_array_chart[0],responce.fees_array_chart[1],responce.fees_array_chart[2]);

					//Bar color
					jQuery.each(responce.fees_array_chart[0], function(index, fee_value){
						var fee_chart_item = jQuery('<div />', { class: 'item item-'+index });
						jQuery('.wcpfc-top-ten .wcpfc-chart-legend').append(fee_chart_item);

						var fee_item_bar = jQuery('<div />', { class: 'bar' }).css('background', fee_value);
						jQuery('.wcpfc-top-ten .wcpfc-chart-legend .item.item-'+index).append(fee_item_bar);
					});

					//Name color
					jQuery.each(responce.fees_array_chart[1], function(index, fee_value){
						var fee_item_label = jQuery('<div />', { class: 'label' }).html(fee_value);
						jQuery('.wcpfc-top-ten .wcpfc-chart-legend .item.item-'+index).append(fee_item_label);
					});

					//Revenue color
					jQuery.each(responce.fees_array_chart[2], function(index, fee_value){
						var fee_item_data = jQuery('<div />', { class: 'data' }).html(responce.currency_symbol+fee_value);
						jQuery('.wcpfc-top-ten .wcpfc-chart-legend .item.item-'+index).append(fee_item_data);
					});

				} else {
					var fee_table_row = jQuery('<div />', { class: 'wcpfc-table-row' });
					jQuery('.wcpfc-top-ten .wcpfc-table').append(fee_table_row);
					var fee_table_row_item = jQuery('<div />', { class: 'wcpfc-table-no-item' }).html(responce.message);
					jQuery('.wcpfc-top-ten .wcpfc-table .wcpfc-table-row').append(fee_table_row_item);
				}
				
				jQuery('.wcpfc-top-ten').removeClass('wcpfc-loader');
			},
		});
	}

	//Top 10 Fee chart
	function wcpfc_top_ten_fees_chart(wcpfc_color, wcpfc_labels, wcpfc_data){
		var ctx = document.getElementById('topFeeChart');
		var topFeeChart = new Chart(ctx, {
			type: 'pie',
			data: {
				labels: wcpfc_labels,
				  datasets: [{
					data: wcpfc_data,
					backgroundColor: wcpfc_color,
					hoverOffset: 3
				}]
			},
			options: {
				animation:{
					duration: 1000,
				},
				plugins: {
					legend: {
						display: false
					}
				},
				responsive : true,
				maintainAspectRatio: true,
				aspectRatio	: 1.5
			}
		});
		topFeeChart.update();
	
		jQuery(document).on('click', '.wcpfc-chart-legend .item', function(){ 
			var currentIndex = jQuery(this).index();
			topFeeChart.toggleDataVisibility(currentIndex);
			topFeeChart.update();
			var dataVisibility = topFeeChart.getDataVisibility(currentIndex);
			if(dataVisibility){
				jQuery(this).removeClass('inactive');
			} else {
				jQuery(this).addClass('inactive');
			}
		});
	}

	//Export all fee with revenue in csv file
	jQuery('body').on('click', '.export-all-fees', function(e){
		e.preventDefault();
		jQuery('.wcpfc-top-ten').addClass('wcpfc-loader');
		jQuery.ajax({
			url: coditional_vars.ajaxurl,
			type: 'post',
			data: {
				action : 'export_all_fees_revenue',
				nonce  : coditional_vars.dashboard_ajax_nonce,
			},
			success: function (responce) {

				jQuery('.responce_message').remove();
				var message = jQuery('<span/>', { class: 'responce_message success', text: responce.message }).insertAfter('.wcpfc-top-ten .wcpfc-title');
				
				if(responce.success){
					var dynamic_download = jQuery('<a />', { href: responce.file, download: responce.filename });
					jQuery('body').append(dynamic_download);
					dynamic_download[0].click();
					jQuery('body').remove(dynamic_download);
				}

				setTimeout(function(){
					message.remove();
				}, 5000);
				
				jQuery('.wcpfc-top-ten').removeClass('wcpfc-loader');
			},
		});
	});

	if (jQuery('#is_allow_custom_weight_base').is(':checked')) {
		jQuery('.wcpfc-section-left .wcpfc-main-table .depend_of_custom_weight_base').show();
	} else {
		jQuery('.wcpfc-section-left .wcpfc-main-table .depend_of_custom_weight_base').hide();
	}
	if (jQuery('#is_allow_custom_qty_base').is(':checked')) {
		jQuery('.wcpfc-section-left .wcpfc-main-table .depend_of_custom_qty_base').show();
	} else {
		jQuery('.wcpfc-section-left .wcpfc-main-table .depend_of_custom_qty_base').hide();
	}
	jQuery(document).on('change', '#is_allow_custom_weight_base', function () {
		if (this.checked) {
			jQuery('.wcpfc-section-left .wcpfc-main-table .depend_of_custom_weight_base').show();
		} else {
			jQuery('.wcpfc-section-left .wcpfc-main-table .depend_of_custom_weight_base').hide();
		}
	});

	if (jQuery('#chk_enable_custom_fun').is(':checked')) {
		jQuery('.table-mastersettings #enable_all_fee_tax, .table-mastersettings #enable_all_fee_tooltip, .table-mastersettings #enable_all_fee_tooltip_text').show();
	} else {
		jQuery('.table-mastersettings #enable_all_fee_tax, .table-mastersettings #enable_all_fee_tooltip, .table-mastersettings #enable_all_fee_tooltip_text').hide();
	}
	jQuery(document).on('change', '#chk_enable_custom_fun', function () {
		if (this.checked) {
			jQuery('.table-mastersettings #enable_all_fee_tax, .table-mastersettings #enable_all_fee_tooltip, .table-mastersettings #enable_all_fee_tooltip_text').show();
		} else {
			jQuery('.table-mastersettings #enable_all_fee_tax, .table-mastersettings #enable_all_fee_tooltip, .table-mastersettings #enable_all_fee_tooltip_text').hide();
		}
	});

	jQuery( 'body' ).on( 'click', '.reset-cache', function() {
		jQuery.ajax({
			type: 'POST',
			url: coditional_vars.ajaxurl,
			data: {
				'action': 'wcpfc_reset_fee_cache',
				'nonce': coditional_vars.dsm_ajax_nonce,
			},
			success: function( response ) {
				alert( response );
				location.reload();
			}
		});
	});

	if( ( coditional_vars.total_old_revenue_flag === '' || !coditional_vars.total_old_revenue_flag ) && location.search.indexOf('wcpfc-pro-dashboard') > -1 ){
		jQuery('.progress').css( 'width', 0 );
		recursive_migration(0, 0);
	}
	/* </fs_premium_only> */
	
	// script for plugin rating
	jQuery(document).on('click', '.dotstore-sidebar-section .content_box .et-star-rating label', function(e){
		e.stopImmediatePropagation();
		var rurl = jQuery('#et-review-url').val();
		window.open( rurl, '_blank' );
	});

    /** tiptip js implementation */
    jQuery( '.woocommerce-help-tip' ).tipTip( {
        'attribute': 'data-tip',
        'fadeIn': 50,
        'fadeOut': 50,
        'delay': 200,
        'keepAlive': true
    } );

    //Toggle sidebar start
    var span_full = jQuery('.toggleSidebar .dashicons');
    var show_sidebar = localStorage.getItem('wcpfc-sidebar-display');
    if( ( null !== show_sidebar || undefined !== show_sidebar ) && ( 'hide' === show_sidebar ) ) {
        jQuery('.all-pad').addClass('hide-sidebar');
        span_full.removeClass('dashicons-arrow-right-alt2').addClass('dashicons-arrow-left-alt2');
    } else {
        jQuery('.all-pad').removeClass('hide-sidebar');
        span_full.removeClass('dashicons-arrow-left-alt2').addClass('dashicons-arrow-right-alt2');
    }

    jQuery(document).on( 'click', '.toggleSidebar', function(){
        jQuery('.all-pad').toggleClass('hide-sidebar');
        if( jQuery('.all-pad').hasClass('hide-sidebar') ){
            localStorage.setItem('wcpfc-sidebar-display', 'hide');
            span_full.removeClass('dashicons-arrow-right-alt2').addClass('dashicons-arrow-left-alt2');
            jQuery('.all-pad .dots-settings-right-side').css({'-webkit-transition': '.3s ease-in width', '-o-transition': '.3s ease-in width',  'transition': '.3s ease-in width'});
            jQuery('.all-pad .dots-settings-left-side').css({'-webkit-transition': '.3s ease-in width', '-o-transition': '.3s ease-in width',  'transition': '.3s ease-in width'});
            setTimeout(function() {
                jQuery('#dotsstoremain .dotstore_plugin_sidebar').css('display', 'none');
            }, 300);
        } else {
            localStorage.setItem('wcpfc-sidebar-display', 'show');
            span_full.removeClass('dashicons-arrow-left-alt2').addClass('dashicons-arrow-right-alt2');
            jQuery('.all-pad .dots-settings-right-side').css({'-webkit-transition': '.3s ease-out width', '-o-transition': '.3s ease-out width',  'transition': '.3s ease-out width'});
            jQuery('.all-pad .dots-settings-left-side').css({'-webkit-transition': '.3s ease-out width', '-o-transition': '.3s ease-out width',  'transition': '.3s ease-out width'});
            // setTimeout(function() {
                jQuery('#dotsstoremain .dotstore_plugin_sidebar').css('display', 'block');
            // }, 300);
        }
    });
    //Toggle sidebar end

    jQuery(document).on('click', '.notice-dismiss', function(){ 
        jQuery(this).parent().remove(); 
    });
} );

/* <fs_premium_only> */
function recursive_migration(offset, total_revenue){
	jQuery.ajax({
		type: 'POST',
		url: coditional_vars.ajaxurl,
		data: {
			'action': 'wcpfc_migration_old_fee',
			'offset': offset,
			'total_revenue': total_revenue,
			'nonce': coditional_vars.dsm_ajax_nonce,
		},
		success: function( response ) {
			if( response.recusrsive ){
				var	progress = parseFloat( (response.offset/response.total_chunk)*100 );
				jQuery('.progress_count').html(progress.toFixed(2));
				jQuery('.progress').animate({ 
					width: progress+'%'
				}, 200);
				recursive_migration(response.offset, response.total_revenue);
			} else {
				console.log( response.total_revenue );
				location.reload();
			}
		}
	});
}
/* </fs_premium_only> */

jQuery( window ).resize( function() {
	if ( jQuery( window ).width() <= 980 ) {
		jQuery( '.fees-pricing-rules .fees_pricing_rules .tab-content' ).click( function() {
			var acc_id = jQuery( this ).attr( 'id' );
			jQuery( '.fees-pricing-rules .fees_pricing_rules .tab-content' ).removeClass( 'current' );
			jQuery( '#' + acc_id ).addClass( 'current' );
		} );
	}
} );