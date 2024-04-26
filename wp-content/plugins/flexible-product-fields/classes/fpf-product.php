<?php

if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use WPDesk\FPF\Free\Field\TemplateArgs;
use WPDesk\FPF\Free\Field\Type\RadioType;
use WPDesk\FPF\Free\Field\Type\MultiCheckboxType;

class FPF_Product {

	/**
	 * Priority before default
	 */
	const HOOK_BEFORE_DEFAULT = 9;

	/**
	 * Priority after default
	 */
	const HOOK_AFTER_DEFAULT = 20;

	/**
     * Is hook woocommerce_before_add_to_cart_button already fired?
     *
	 * @var bool
	 */
	private $is_woocommerce_before_add_to_cart_button_fired = false;

	/**
	 * @var null|Flexible_Product_Fields
	 */
    private $_plugin = null;

	/**
	 * @var FPF_Product_Fields|null
	 */
    private $_product_fields = null;

	/**
	 * Product price.
	 *
	 * @var FPF_Product_Price|null
	 */
	private $product_price = null;

	/**
	 * FPF_Product constructor.
	 *
	 * @param Flexible_Product_Fields $plugin
	 * @param FPF_Product_Fields $product_fields
	 */
    public function __construct( Flexible_Product_Fields_Plugin $plugin, FPF_Product_Fields $product_fields, FPF_Product_Price $product_price ) {
        $this->_plugin = $plugin;
        $this->_product_fields = $product_fields;
        $this->product_price = $product_price;
        $this->hooks();
    }

	/**
	 *
	 */
    public function hooks() {

        add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'woocommerce_before_add_to_cart_button' ) );
        add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'woocommerce_after_add_to_cart_button' ) );

        add_filter( 'woocommerce_product_supports', array( $this, 'woocommerce_product_supports' ), 10, 3 );

    }

	/**
	 * @param string $error
	 */
    public function add_error( $error ) {
        wc_add_notice( $error, 'error' );
    }

	/**
	 * @param bool $supports
	 * @param string $feature
	 * @param WC_Product $product
	 *
	 * @return bool
	 */
    public function woocommerce_product_supports( $supports, $feature, $product ) {
        if ( 'ajax_add_to_cart' === $feature && $this->product_has_required_field( $product ) ) {
            $supports = false;
        }
        return $supports;
    }

	/**
	 * @param string $type
	 *
	 * @return array
	 */
    public function get_field_type( $type ) {
        $ret = array();
        $field_types = $this->_product_fields->get_field_types();
        foreach ( $field_types as $field_type ) {
            if ( $field_type['value'] == $type ) {
                return $field_type;
            }
        }
        return $ret;
    }

	/**
	 * @param WC_Product $product
	 *
	 * @return bool
	 */
    public function product_has_required_field( $product ) {
        $fields = $this->get_translated_fields_for_product( $product );
        return $fields['has_required'];
    }

	/**
     * Get translated fields for product.
     * Titles and labels will be translated to current language.
     *
	 * @param WC_Product $product
	 * @param bool|string $hook
	 *
	 * @return array
	 */
    public function get_translated_fields_for_product( $product, $hook = false ) {
        return $this->translate_fields_titles_and_labels( $this->get_fields_for_product( $product, $hook ) );
    }

	/**
	 * @param WC_Product $product
	 * @param bool|string $hook
	 *
	 * @return array
	 */
	public function get_fields_for_product( $product, $hook = false ) {
		$cache_key = 'product_' . wpdesk_get_product_id( $product );
		if ( $hook ) {
			$cache_key .= '_h_' . $hook;
		}
		$ret = $this->_product_fields->cache_get( $cache_key );
		if ( $ret === false ) {
			$ret = array(
				'posts' => array(),
				'fields' => array(),
				'display_fields' => array(),
				'has_required' => false
			);
			$fields_posts = array();
			$args = array(
				'post_type' => 'fpf_fields',
				'posts_per_page' => -1,
				'meta_query' => array(
					array(
						'key' => '_assign_to',
						'value' => 'product',
						'compare' => '='
					),
					array(
						'key' => '_product_id',
						'value' => wpdesk_get_product_id( $product ),
						'compare' => '='
					),
				),
			);
			if ( $hook ) {
				$args['meta_query'][] = array(
					'key' => '_section',
					'value' => $hook,
					'compare' => '='
				);
			}
			$posts = get_posts($args);
			foreach ($posts as $post) {
				$ret['posts'][$post->ID] = $post;
			}

			$categories = wp_get_post_terms( wpdesk_get_product_id( $product ), 'product_cat', array( 'fields' => 'ids' ) );
			foreach ( $categories as $category ) {
				$cat_cache_key = 'category_' . $category;
				if ( $hook ) {
					$cat_cache_key .= '_h_' . $hook;
				}
				$posts = $this->_product_fields->cache_get( $cat_cache_key );
				if ( $posts === false ) {
					$args = array(
						'post_type' => 'fpf_fields',
						'posts_per_page' => -1,
						'meta_query' => array(
							array(
								'key' => '_assign_to',
								'value' => 'category',
								'compare' => '='
							),
							array(
								'key' => '_category_id',
								'value' => $category,
								'compare' => 'in'
							),
						),
					);
					if ($hook) {
						$args['meta_query'][] = array(
							'key' => '_section',
							'value' => $hook,
							'compare' => '='
						);
					}
					$posts = get_posts($args);
					$this->_product_fields->cache_set( $cat_cache_key, $posts );
				}
				foreach ($posts as $post) {
					$ret['posts'][$post->ID] = $post;
				}
			}

			$tags = wp_get_post_terms( wpdesk_get_product_id( $product ), 'product_tag', array( 'fields' => 'ids' ) );
			foreach ( $tags as $tag ) {
				$cat_cache_key = 'tag_' . $tag;
				if ( $hook ) {
					$cat_cache_key .= '_h_' . $hook;
				}
				$posts = $this->_product_fields->cache_get( $cat_cache_key );
				if ( $posts === false ) {
					$args = array(
						'post_type' => 'fpf_fields',
						'posts_per_page' => -1,
						'meta_query' => array(
							array(
								'key' => '_assign_to',
								'value' => 'tag',
								'compare' => '='
							),
							array(
								'key' => '_tag_id',
								'value' => $tag,
								'compare' => 'in'
							),
						),
					);
					if ($hook) {
						$args['meta_query'][] = array(
							'key' => '_section',
							'value' => $hook,
							'compare' => '='
						);
					}
					$posts = get_posts($args);
					$this->_product_fields->cache_set( $cat_cache_key, $posts );
				}
				foreach ($posts as $post) {
					$ret['posts'][$post->ID] = $post;
				}
			}

			$cat_cache_key = 'all';
			if ( $hook ) {
				$cat_cache_key .= '_h_' . $hook;
			}
			$posts = $this->_product_fields->cache_get( $cat_cache_key );
			if ( $posts === false ) {
				$args = array(
					'post_type' => 'fpf_fields',
					'posts_per_page' => -1,
					'meta_query' => array(
						array(
							'key' => '_assign_to',
							'value' => 'all',
							'compare' => '='
						),
					),
				);
				if ($hook) {
					$args['meta_query'][] = array(
						'key' => '_section',
						'value' => $hook,
						'compare' => '='
					);
				}
				$posts = get_posts($args);
				$this->_product_fields->cache_set( $cat_cache_key, $posts );
			}
			foreach ($posts as $post) {
				$ret['posts'][$post->ID] = $post;
			}
			$ret['posts'] = apply_filters( 'flexible_product_fields_sort_groups_posts', $ret['posts'] );
			foreach ( $ret['posts'] as $key => $post ) {
				$ret['posts'][$key]->fields_meta = get_post_meta( $post->ID, '_fields', true );
				if ( is_array( $ret['posts'][$key]->fields_meta ) ) {
					$new_fields = array_map(
						function ( $field_data ) use ( $post ) {
							$field_data['_group_id'] = $post->ID;
							return $field_data;
						},
						$ret['posts'][$key]->fields_meta
					);
					$ret['fields'] = array_merge($ret['fields'], $new_fields);
				}
			}
			foreach ( $ret['fields'] as $key => $field ) {
				$field_type = $this->get_field_type( $field['type'] );
				$ret['fields'][$key]['has_price'] = isset( $field_type['has_price'] ) ? $field_type['has_price'] : false;
				$ret['fields'][$key]['has_price_in_options'] = isset( $field_type['has_price_in_options'] ) ? $field_type['has_price_in_options'] : false;
				$ret['fields'][$key]['has_options'] = $field_type['has_options'];
				if ( empty( $field_type['is_available'] ) && !$field_type['is_available'] ) {
					unset( $ret['fields'][$key] );
				}
				else {
					if ( isset( $field['required'] ) && ( $field['required'] == 1 ) ) {
						$ret['has_required'] = true;
					}
				}
			}
			$this->_product_fields->cache_set( $cache_key, $ret );
		}
		return $ret;
	}

	/**
	 * @param WC_Product $product
	 *
	 * @return array
	 */
    public function get_logic_rules_for_product( $product ) {
        $fields = $this->get_translated_fields_for_product( $product );
	    $rules = array();
        foreach ( $fields['fields'] as $field ) {
            if ( isset( $field['logic'] ) && $field['logic'] == '1' && isset( $field['logic_operator'] ) && isset( $field['logic_rules'] ) ) {
                $rules[$field['id']] = array();
	            $rules[$field['id']]['rules'] = $field['logic_rules'];
	            $rules[$field['id']]['operator'] = $field['logic_operator'];
            }
        }
        return $rules;
    }

	/**
	 * @param WC_Product $product
	 * @param bool|string $hook
	 *
	 * @return array
	 */
    public function create_fields_for_product( $product, $hook ) {
        $fields = $this->get_translated_fields_for_product( $product, $hook );
        foreach ( $fields['fields'] as $field ) {
            $fields['display_fields'][] = $this->create_field( $field, $product );
        }
		return $fields;
    }

	/**
	 * @param array $field
	 * @param WC_Product $product
	 *
	 * @return string
	 */
    public function create_field( array $field, WC_Product $product ) {
        $field_type    = $this->get_field_type( $field['type'] );
		$template_vars = $field_type['type_object']->get_field_template_vars( $field );

		$template_vars['value'] = $field_type['type_object']->get_field_value( $field['id'], true );
		$template_vars['args']  = ( new TemplateArgs() )->parse_field_args(
			$field_type,
			$field_type['type_object'],
			$field,
			$this->product_price,
			$product
		);

		return $this->_plugin->load_template(
			$field_type['template_file'],
			'fields',
			$template_vars
		);
    }

	/**
	 * @param bool|string $hook
	 */
    public function show_fields( $hook ) {
        global $product;
        $fields = $this->create_fields_for_product( $product, $hook );
        if ( count( $fields['display_fields'] ) ) {
            echo $this->_plugin->load_template( $hook, 'hooks', array( 'fields' => $fields['display_fields'] ) );
        }
    }

	/**
     * Translate fields titles and labels.
     *
	 * @param array $fields
	 *
	 * @return array
	 */
    private function translate_fields_titles_and_labels( array $fields ) {
	    foreach ( $fields['fields'] as $key => $field ) {
	        $field['title'] = wpdesk__( $field['title'], 'flexible-product-fields' );
	        if ( isset( $field['placeholder'] ) ) {
		        $field['placeholder'] = wpdesk__( $field['placeholder'], 'flexible-product-fields' );
	        }
		    if ( $field['has_options'] ) {
			    foreach ( $field['options'] as $option_key => $option ) {
				    $field['options'][ $option_key ]['label'] = wpdesk__( $option['label'], 'flexible-product-fields' );
			    }
		    }
		    $fields['fields'][ $key ] = $field;
        }
        return $fields;
    }

	/**
	 * Fired by woocommerce_before_add_to_cart_button hook.
	 */
    public function woocommerce_before_add_to_cart_button() {
        /** Prevent display fields more than once. Action may be fired by other third party plugins, ie. Woocommerce Subscriptions */
        if ( $this->is_woocommerce_before_add_to_cart_button_fired ) {
            return;
        }
	    $this->is_woocommerce_before_add_to_cart_button_fired = true;
        global $product;
	    $product_extended_info = new FPF_Product_Extendend_Info( $product );
        if ( $product_extended_info->is_type_grouped() ) {
            return;
        }
        $this->show_fields( 'woocommerce_before_add_to_cart_button' );
        echo $this->_plugin->load_template( 'display', 'totals', array() );
        $fields = $this->translate_fields_titles_and_labels( $this->get_translated_fields_for_product( $product ) );
        foreach ( $fields['fields'] as $key => $field ) {
            $fields['fields'][$key]['price_value'] = 0;
            if ( !isset( $field['price_type'] ) ) {
	            $field['price_type'] = 'fixed';
	            $fields['fields'][$key]['price_type'] = 'fixed';
            }
            if ( $field['has_price'] && isset($field['price_type']) && $field['price_type'] != '' && isset($field['price']) && $field['price'] != '' ) {
            	$price_value = $this->product_price->calculate_price( floatval($field['price']), $field['price_type'], $product );
                $fields['fields'][$key]['price_value'] = $price_value;
	            $fields['fields'][$key]['price_display'] = $this->product_price->prepare_price_to_display( $product, $price_value );
            }
            if ( $field['has_options'] ) {
				foreach ( $fields['fields'][$key]['options'] as $option_key => $option ) {
                    $fields['fields'][ $key ]['options'][ $option_key ]['price_value'] = 0;
	                if ( ! $field['has_price_in_options'] ) {
						continue;
					}

            		$price_values       = $field['price_values'] ?? [];
	                $option_price_type  = $price_values[ $option['value'] ]['price_type'] ?? ( $option['price_type'] ?? '' );
	                $option_price_value = $price_values[ $option['value'] ]['price'] ?? ( $option['price'] ?? '' );
	                if ( ( $option_price_type === '' ) || ( $option_price_value === '' ) ) {
	                	continue;
					}

					$price_value = $this->product_price->calculate_price( floatval($option_price_value ), $option_price_type, $product );
					$fields['fields'][ $key ]['options'][ $option_key ]['price_type']    = $option_price_type;
					$fields['fields'][ $key ]['options'][ $option_key ]['price']         = $option_price_value;
					$fields['fields'][ $key ]['options'][ $option_key ]['price_value']   = $price_value;
					$fields['fields'][ $key ]['options'][ $option_key ]['price_display'] = $this->product_price->prepare_price_to_display( $product, $price_value );
                }
			}
        }
        $tax_display_mode = get_option( 'woocommerce_tax_display_shop' );
        if ( $tax_display_mode == 'excl' ) {
	        $product_price = wpdesk_get_price_excluding_tax( $product );
        }
        else {
	        $product_price = wpdesk_get_price_including_tax( $product );
        }
		?>
        <script type="text/javascript">
            var fpf_fields = <?php echo json_encode( $fields['fields'] ); ?>;
            var fpf_product_price = <?php echo json_encode( $product_price ); ?>;
        </script>
        <?php
    }

	/**
	 *
	 */
    public function woocommerce_after_add_to_cart_button() {
	    global $product;
	    $product_extended_info = new FPF_Product_Extendend_Info( $product );
	    if ( $product_extended_info->is_type_grouped() ) {
		    return;
	    }
        $this->show_fields( 'woocommerce_after_add_to_cart_button' );
    }


}
