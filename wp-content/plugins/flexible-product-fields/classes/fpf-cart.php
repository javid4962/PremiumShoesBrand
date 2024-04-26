<?php

/**
 * Handles WooCommerce add to cart.
 */
class FPF_Cart {

	/**
	 * Priority before default
	 */
	const HOOK_BEFORE_DEFAULT = 9;

	/**
	 * Priority after default
	 */
	const HOOK_AFTER_DEFAULT = 20;

	/**
	 * Plugin
	 *
	 * @var Flexible_Product_Fields_Plugin
	 */
	private $_plugin;

	/**
	 * @var FPF_Product_Fields
	 */
    private $_product_fields = null;

	/**
	 * @var FPF_Product|null
	 */
    private $_product = null;

	/**
	 * Product price.
	 *
	 * @var FPF_Product_Price|null
	 */
	private $product_price = null;

	/**
	 * FPF_Cart constructor.
	 *
	 * @param Flexible_Product_Fields_Plugin $plugin
	 * @param FPF_Product_Fields $product_fields
	 * @param FPF_Product $product
	 */
    public function __construct( Flexible_Product_Fields_Plugin $plugin, FPF_Product_Fields $product_fields, FPF_Product $product, FPF_Product_Price $product_price ) {
        $this->_plugin = $plugin;
        $this->_product_fields = $product_fields;
        $this->_product = $product;
	    $this->product_price = $product_price;
        add_action( 'plugins_loaded', array( $this, 'hooks' ) );
    }

	/**
	 * Define hooks
	 */
	public function hooks() {
		add_filter( 'woocommerce_add_to_cart_handler', [ $this, 'woocommerce_add_to_cart_handler' ], 10, 2 );
		add_filter( 'woocommerce_get_cart_item_from_session', [ $this, 'woocommerce_get_cart_item_from_session' ], self::HOOK_AFTER_DEFAULT, 2 );
		add_filter( 'woocommerce_get_item_data', [ $this, 'woocommerce_get_item_data' ], 10, 2 );
		add_action( 'woocommerce_new_order_item', [ $this, 'woocommerce_new_order_item' ], 10, 3 );
		// moreConvert integration.
		add_action( 'wlfmc_add_to_list_handler', [ $this, 'woocommerce_add_to_cart_handler' ], 10, 2 );
		add_filter( 'wlfmc_third_party_item_price', [ $this, 'woocommerce_add_cart_item' ], 20 );
		add_filter( 'wlfmc_add_to_cart_handler', [ $this, 'woocommerce_add_cart_item_data' ], 10, 3 );
	}

	/**
	 * Handle filters and actions for add to cart process but not for grouped product.
	 * @param string $type
	 * @param int $product_id
	 *
	 * @return string
	 */
    public function woocommerce_add_to_cart_handler( $type, $product_id ) {
		if ( $type != FPF_Product_Extendend_Info::PRODUCT_TYPE_GROUPED ) {
			add_filter( 'woocommerce_add_cart_item', array( $this, 'woocommerce_add_cart_item' ), self::HOOK_AFTER_DEFAULT, 1 );
			add_filter( 'woocommerce_add_cart_item_data', array( $this, 'woocommerce_add_cart_item_data' ), self::HOOK_AFTER_DEFAULT, 3 );
		}
		return $type;
	}

    private function validate_product_referer_id( array $product_data ): bool {
    	$product_id = $product_data['product_id'] ?? null;
    	$referer_id = $product_data['flexible_product_fields_product_id'] ?? null;

    	return ( ( $product_id !== null ) && ( $referer_id !== null ) && ( $product_id == $referer_id ) );
	}

	/**
	 * @param int $item_id
	 * @param array $values
	 */
	public function woocommerce_add_order_item_meta( $item_id, $values ) {
    	$fields = $values['flexible_product_fields'] ?? [];
    	if ( $fields && $this->validate_product_referer_id( $values ) ) {
            foreach ( $fields as $field ) {
                $name = $field['name'];
                wc_add_order_item_meta( $item_id, $name, $field['value'] );
            }
        }
    }

	/**
	 * @param int $item_id
	 * @param mixed $item
	 * @param int $order_id
	 */
    public function woocommerce_new_order_item( $item_id, $item, $order_id ) {
		if ( $item instanceof WC_Order_Item_Product ) {
			if ( ! empty( $item->legacy_values ) && ! empty( $item->legacy_values['flexible_product_fields'] )
				&& $this->validate_product_referer_id( $item->legacy_values ) ) {
			    foreach ( $item->legacy_values['flexible_product_fields'] as $field ) {
				    $name = $field['name'];
				    wc_add_order_item_meta( $item_id, $name, $field['value'] );
			    }
		    }
	    }
    }

	/**
	 * @param array $cart_item
	 * @param array $values
	 *
	 * @return mixed
	 */
    public function woocommerce_get_cart_item_from_session( $cart_item, $values ) {
    	$fields = $values['flexible_product_fields'] ?? [];
    	if ( ! $fields || ! $this->validate_product_referer_id( $values ) ) {
        	return $cart_item;
		}

		$cart_item['flexible_product_fields'] = $values['flexible_product_fields'];
		return $this->woocommerce_add_cart_item( $cart_item );
    }

	/**
	 * @param array $cart_item
	 *
	 * @return array mixed
	 */
    public function woocommerce_add_cart_item( $cart_item ) {
    	$fields = $cart_item['flexible_product_fields'] ?? [];
    	if ( ! $fields || ! $this->validate_product_referer_id( $cart_item ) ) {
        	return $cart_item;
		}

		$product_id = empty( $cart_item['variation_id'] ) ? $cart_item['product_id'] : $cart_item['variation_id'];
		$product = \wc_get_product( $product_id );
		if ( ! $product instanceof \WC_Product ) {
			return $cart_item;
		}

    	$extra_cost = 0;
		foreach ( $fields as $key => $field ) {
			if ( isset( $field['price_type'] ) && $field['price_type'] != '' && isset( $field['price'] ) && floatval( $field['price'] ) != 0 ) {
				$field_price = floatval( $field['price'] );
				$field_price_type = (string) $field['price_type'];
				$field_price_current_currency = $this->field_price_multicurrency( $field_price, $field_price_type, $product );

				$extra_cost += $field_price_current_currency;

				$org_value = isset( $field['org_value'] ) ? (string) $field['org_value'] : '';
				$cart_item['flexible_product_fields'][$key]['value'] = $this->field_display_value( $field_price_current_currency, $org_value );
			}
		}
		$cart_item['data']->set_price( $cart_item['data']->get_price( 'edit' ) + $extra_cost );

        return $cart_item;
    }

	/**
	 * Get field data from posted fields.
	 *
	 * @param array       $field Field.
	 * @param array       $field_type Settings of field type.
	 * @param string|null $value Value of field.
	 * @param int         $product_id Product ID.
	 * @param int         $variation_id Variation ID.
	 *
	 * @return array|bool|WP_Error
	 */
    private function get_field_data( $field, $field_type, $value, $product_id, $variation_id ) {
		$ret = false;

        if ( $value != null ) {
            $ret = array(
                'name' => $field['title'],
                'value' => $value,
            );
            if ( $field['type'] == 'checkbox' ) {
            	if ( !isset( $field['value'] ) ) {
            	    $ret['value'] = __( 'yes', 'flexible-product-fields' );
	            }
	            else {
		            $ret['value'] = $field['value'];
	            }
            }
            if ( $field_type['has_price'] ) {
            	if ( !isset( $field['price_type'] ) ) {
		            $field['price_type'] = 'fixed';
	            }
                if ( isset($field['price_type']) && $field['price_type'] != '' && isset($field['price']) && $field['price'] != '' ) {
                    $ret['price_type'] = $field['price_type'];
                    $ret['price'] = $field['price'];
                }
            }
            if ( $field_type['has_options'] ) {
                foreach ( $field['options'] as $option ) {
                    if ( trim( $option['value'] ) === $ret['value'] ) {
                        $ret['value'] = $option['label'];
                        if ( ! $field_type['has_price_in_options'] ) {
							continue;
						}

						$price_values       = $field['price_values'] ?? [];
						$option_price_type  = $price_values[ $option['value'] ]['price_type'] ?? ( $option['price_type'] ?? '' );
						$option_price_value = $price_values[ $option['value'] ]['price'] ?? ( $option['price'] ?? '' );

						if ( ( $option_price_type === '' ) || ( $option_price_value === '' ) ) {
							continue;
						}

						$ret['price_type'] = $option_price_type;
						$ret['price']      = $option_price_value;
                    }
                }
            }
            if ( isset($ret['price_type']) && $ret['price_type'] != '' && isset($ret['price']) && $ret['price'] != '' ) {
            	if ( $variation_id ) {
            		$product_id = $variation_id;
				}

                $product = wc_get_product( $product_id );
				$field_price = floatval( $ret['price'] );
				$field_price_type = (string) $ret['price_type'];
				$field_price_current_currency = $this->field_price_multicurrency( $field_price, $field_price_type, $product );

				$ret['org_value'] = isset( $ret['value'] ) ? (string) $ret['value'] : '';
				$ret['value'] = $this->field_display_value( $field_price_current_currency, $ret['org_value'] );
            }
        }
		return $ret;
    }

	/**
	 * Calculates price for a specific product field, and returns it with the current currency.
	 *
	 * @param float      $price_or_percent The price (default currency) or percentage to calculate the price from.
	 * @param string     $price_type       The type of price (fixed or percentage).
	 * @return float The current price in the current currency.
	 */
	private function field_price_multicurrency( float $price_or_percent, string $price_type, \WC_Product $product ) : float {
		$price = $this->product_price->calculate_price( $price_or_percent, $price_type, $product );
		$price = $this->product_price->multicurrency_calculate_price_to_display( $price );

		return (float) $price;
	}

	/**
	 * Decides on how product field with price, should be displayed in the cart.
	 */
	private function field_display_value( float $price, string $label ) : string {
		$price = $this->product_price->wc_price( $price );
		$display_value = $label . ' (' . $price . ')';

		return trim( $display_value );
	}

	/**
	 * @param array $other_data
	 * @param array $cart_item
	 *
	 * @return array
	 */
    public function woocommerce_get_item_data( $other_data, $cart_item ) {
    	$fields = $cart_item['flexible_product_fields'] ?? [];
    	if ( ! $fields || ! $this->validate_product_referer_id( $cart_item ) ) {
        	return $other_data;
		}

		foreach ( $fields as $field ) {
			$name         = $field['name'];
			$other_data[] = array(
				'name'    => $name,
				'value'   => $field['value'],
				'display' => $field['display'] ?? ''
			);
		}

        return $other_data;
    }

	/**
	 * @param array $cart_item_data
	 * @param int $product_id
	 * @param int $variation_id
	 *
	 * @return array
	 * @throws Exception
	 */
    public function woocommerce_add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
	    $product_data = wc_get_product( $product_id );
        $fields = $this->_product->get_translated_fields_for_product( $product_data );

        $post_data    = wp_unslash( $_POST );
	    $fields       = apply_filters( 'flexible_product_fields_apply_logic_rules', $fields, $post_data );
		$fields_types = $this->_product_fields->get_field_types_by_type();

		foreach ( $fields['fields'] as $field ) {
			if ( ! isset( $fields_types[ $field['type'] ] ) ) {
				continue;
			}

        	$field_type   = $fields_types[ $field['type'] ];
        	$field_values = $field_type['type_object']->get_field_value( $field['id'] );

			try {
				do_action( 'flexible_product_fields/validate_field', $field, $field_values, $field_type );
			} catch( \Exception $e ) {
				throw new \Exception( $e->getMessage() );
			}

        	if ( ! is_array( $field_values ) ) {
				$field_values = [ $field_values ];
			}

        	foreach ( $field_values as $field_value ) {
				$data = $this->get_field_data( $field, $field_type, $field_value, $product_id, $variation_id );
				if ( $data ) {
					if ( !isset( $cart_item_data['flexible_product_fields'] ) ) {
						$cart_item_data['flexible_product_fields'] = array();
					}
					$cart_item_data['flexible_product_fields'][] = $data;
				}
			}
        }

		if ( isset( $cart_item_data['flexible_product_fields'] ) ) {
			$cart_item_data['flexible_product_fields_product_id'] = $post_data['_fpf_product_id'];
		}

		return $cart_item_data;
    }


}
