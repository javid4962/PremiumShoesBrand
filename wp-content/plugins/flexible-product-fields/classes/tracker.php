<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPDesk_Flexible_Product_Fields_Tracker' ) ) {
	class WPDesk_Flexible_Product_Fields_Tracker {

		public static $script_version = '11';

		public function __construct() {
			$this->hooks();
		}

		public function hooks() {
			add_filter( 'wpdesk_tracker_data', array( $this, 'wpdesk_tracker_data' ), 11 );
			add_filter( 'wpdesk_tracker_notice_screens', array( $this, 'wpdesk_tracker_notice_screens' ) );

			add_filter( 'plugin_action_links_flexible-product-fields/flexible-product-fields.php', array( $this, 'plugin_action_links' ), 1 );
			add_action( 'activated_plugin', array( $this, 'activated_plugin' ), 10, 2 );
		}

		public function wpdesk_tracker_data( $data ) {
			$groups      = $this->get_groups();
			$plugin_data = [
				'groups'      => $this->get_groups_data( $groups ),
				'fields'      => $this->get_fields_data( $groups ),
				'pro_version' => array(
					'is_active'    => is_flexible_products_fields_pro_active() ? '1' : '0',
					'is_activated' => ( get_option( 'api_flexible-product-fields-pro_activated', '' ) === 'Activated' ) ? '1' : '0',
				),
			];

			$data['flexible_product_fields'] = $plugin_data;

			return $data;
		}

		private function get_groups() {
			$post_ids = get_posts( array(
				'post_type'      => 'fpf_fields',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			));
			$items = [];
			foreach ( $post_ids as $post ) {
				$items[] = $this->get_group( $post );
			}
			return $items;
		}

		private function get_group( $post ) {
			return [
				'section'    => get_post_meta( $post->ID, '_section', true ),
				'assign_to'  => get_post_meta( $post->ID, '_assign_to', true ),
				'menu_order' => $post->menu_order,
				'fields'     => get_post_meta( $post->ID, '_fields', true ),
			];
		}

		private function get_groups_data( $groups ) {
			$data = array(
				'section'    => array(),
				'assign_to'  => array(),
				'menu_order' => 0,
			);

			foreach ( $groups as $group ) {
				if ( ! isset( $data['section'][ $group['section'] ] ) ) {
					$data['section'][ $group['section'] ] = 0;
				}
				$data['section'][ $group['section'] ]++;
				if ( ! isset( $data['assign_to'][ $group['assign_to'] ] ) ) {
					$data['assign_to'][ $group['assign_to'] ] = 0;
				}
				$data['assign_to'][ $group['assign_to'] ]++;
				if ( isset( $group['menu_order'] ) && $group['menu_order'] ) {
					$data['menu_order']++;
				}
			}
			return $data;
		}

		private function get_fields_data( $groups ) {
			$default_data = array(
				'count'             => 0,
				'required'          => 0,
				'max_length'        => 0,
				'placeholder'       => 0,
				'value'             => array(
					'min'  => 0,
					'max'  => 0,
					'step' => 0,
				),
				'css_class'         => 0,
				'tooltip'           => 0,
				'options'           => array(),
				'date_format'       => array(),
				'days_before'       => 0,
				'days_after'        => 0,
				'conditional_logic' => array(
					'enabled'       => 0,
					'operator'      => array(),
					'rule_operator' => array(),
				),
				'pricing'           => array(
					'enabled'        => 0,
					'type'           => array(),
					'value_positive' => 0,
					'value_negative' => 0,
				),
			);

			$data = array();
			foreach ( $groups as $group ) {
				foreach ( $group['fields'] as $field ) {
					if ( ! isset( $data[ $field['type'] ] ) ) {
						$data[ $field['type'] ] = $default_data;
					}
					$data[ $field['type'] ]['count']++;

					if ( isset( $field['required'] ) && $field['required'] ) {
						$data[ $field['type'] ]['required']++;
					}
					if ( isset( $field['max_length'] ) && $field['max_length'] ) {
						$data[ $field['type'] ]['max_length']++;
					}
					if ( isset( $field['placeholder'] ) && $field['placeholder'] ) {
						$data[ $field['type'] ]['required']++;
					}
					if ( isset( $field['value_min'] ) && $field['value_min'] ) {
						$data[ $field['type'] ]['value']['min']++;
					}
					if ( isset( $field['value_max'] ) && $field['value_max'] ) {
						$data[ $field['type'] ]['value']['max']++;
					}
					if ( isset( $field['value_step'] ) && $field['value_step'] ) {
						$data[ $field['type'] ]['value']['step']++;
					}
					if ( isset( $field['css_class'] ) && $field['css_class'] ) {
						$data[ $field['type'] ]['css_class']++;
					}
					if ( isset( $field['tooltip'] ) && $field['tooltip'] ) {
						$data[ $field['type'] ]['tooltip']++;
					}
					if ( isset( $field['options'] ) && ( $count = count( $field['options'] ) ) ) {
						if ( ! isset( $data[ $field['type'] ]['options'][ $count ] ) ) {
							$data[ $field['type'] ]['options'][ $count ] = 0;
						}
						$data[ $field['type'] ]['options'][ $count ]++;
						foreach ( $field['options'] as $option ) {
							$data[ $field['type'] ]['pricing'] = $this->get_pricing_data( $option, $data[ $field['type'] ]['pricing'] );
						}
					}
					if ( isset( $field['date_format'] ) && $field['date_format'] ) {
						if ( ! isset( $data[ $field['type'] ]['date_format'][ $field['date_format'] ] ) ) {
							$data[ $field['type'] ]['date_format'][ $field['date_format'] ] = 0;
						}
						$data[ $field['type'] ]['date_format'][ $field['date_format'] ]++;
					}
					if ( isset( $field['days_before'] ) && $field['days_before'] ) {
						$data[ $field['type'] ]['days_before']++;
					}
					if ( isset( $field['days_after'] ) && $field['days_after'] ) {
						$data[ $field['type'] ]['days_after']++;
					}
					if ( isset( $field['days_after'] ) && $field['days_after'] ) {
						$data[ $field['type'] ]['days_after']++;
					}
					if ( isset( $field['days_after'] ) && $field['days_after'] ) {
						$data[ $field['type'] ]['days_after']++;
					}
					$data[ $field['type'] ]['conditional_logic'] = $this->get_conditional_logic_data( $field, $data[ $field['type'] ]['conditional_logic'] );
					$data[ $field['type'] ]['pricing'] = $this->get_pricing_data( $field, $data[ $field['type'] ]['pricing'] );
				}
			}

			return $data;
		}

		private function get_conditional_logic_data( $field, $current_data ) {
			if ( isset( $field['logic'] ) && $field['logic'] ) {
				$current_data['enabled']++;
			} else {
				return $current_data;
			}

			if ( isset( $field['logic_operator'] ) && $field['logic_operator'] ) {
				if ( ! isset( $current_data['operator'][ $field['logic_operator'] ] ) ) {
					$current_data['operator'][ $field['logic_operator'] ] = 0;
				}
				$current_data['operator'][ $field['logic_operator'] ]++;
			}
			if ( isset( $field['logic_rules'] ) && $field['logic_rules'] ) {
				foreach ( $field['logic_rules'] as $rule ) {
					if ( ! isset( $current_data['rule_operator'][ $rule['compare'] ] ) ) {
						$current_data['rule_operator'][ $rule['compare'] ] = 0;
					}
					$current_data['rule_operator'][ $rule['compare'] ]++;
				}
			}

			return $current_data;
		}

		private function get_pricing_data( $field, $current_data ) {
			if ( isset( $field['price'] ) && $field['price'] ) {
				$current_data['enabled']++;
				if ( $field['price'] > 0 ) {
					$current_data['value_positive']++;
				} else if ( $field['price'] < 0 ) {
					$current_data['value_negative']++;
				}
			} else {
				return $current_data;
			}

			if ( isset( $field['price_type'] ) && $field['price_type'] ) {
				if ( ! isset( $current_data['type'][ $field['price_type'] ] ) ) {
					$current_data['type'][ $field['price_type'] ] = 0;
				}
				$current_data['type'][ $field['price_type'] ]++;
			}

			return $current_data;
		}

		public function wpdesk_tracker_notice_screens( $screens ) {
			$current_screen = get_current_screen();
			if ( in_array( $current_screen->id, array( 'fpf_fields', 'edit-fpf_fields' ) ) ) {
				$screens[] = $current_screen->id;
			}
			return $screens;
		}

		public function plugin_action_links( $links ) {
			if ( !wpdesk_tracker_enabled() || apply_filters( 'wpdesk_tracker_do_not_ask', false ) ) {
				return $links;
			}
			$options = get_option('wpdesk_helper_options', array() );
			if ( !is_array( $options ) ) {
				$options = array();
			}
			if ( empty( $options['wpdesk_tracker_agree'] ) ) {
				$options['wpdesk_tracker_agree'] = '0';
			}
			$plugin_links = array();
			if ( $options['wpdesk_tracker_agree'] == '0' ) {
				$opt_in_link = admin_url( 'admin.php?page=wpdesk_tracker&plugin=flexible-product-fields/flexible-product-fields.php' );
				$plugin_links[] = '<a href="' . $opt_in_link . '">' . __( 'Opt-in', 'flexible-product-fields' ) . '</a>';
			}
			else {
				$opt_in_link = admin_url( 'plugins.php?wpdesk_tracker_opt_out=1&plugin=flexible-product-fields/flexible-product-fields.php' );
				$plugin_links[] = '<a href="' . $opt_in_link . '">' . __( 'Opt-out', 'flexible-product-fields' ) . '</a>';
			}
			return array_merge( $plugin_links, $links );
		}


		public function activated_plugin( $plugin, $network_wide ) {
			if ( $network_wide ) {
				return;
			}
			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				return;
			}
			if ( !wpdesk_tracker_enabled() ) {
				return;
			}
			if ( $plugin == 'flexible-product-fields/flexible-product-fields.php' ) {
				$options = get_option('wpdesk_helper_options', array() );

				if ( empty( $options ) ) {
					$options = array();
				}
				if ( empty( $options['wpdesk_tracker_agree'] ) ) {
					$options['wpdesk_tracker_agree'] = '0';
				}
				$wpdesk_tracker_skip_plugin = get_option( 'wpdesk_tracker_skip_flexible_product_fields', '0' );
				if ( $options['wpdesk_tracker_agree'] == '0' && $wpdesk_tracker_skip_plugin == '0' ) {
					update_option( 'wpdesk_tracker_notice', '1' );
					update_option( 'wpdesk_tracker_skip_flexible_product_fields', '1' );
					if ( !apply_filters( 'wpdesk_tracker_do_not_ask', false ) ) {
						wp_redirect( admin_url( 'admin.php?page=wpdesk_tracker&plugin=flexible-product-fields/flexible-product-fields.php' ) );
						exit;
					}
				}
			}
		}

	}

}
