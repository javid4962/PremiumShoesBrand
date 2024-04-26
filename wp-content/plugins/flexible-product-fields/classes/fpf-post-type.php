<?php

use VendorFPF\WPDesk\View\Renderer\Renderer;

if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class FPF_Post_Type {

    const POST_TYPE = 'fpf_fields';

	private $plugin = null;
	private $product_fields = null;

	/**
	 * @var Renderer
	 **/
	private $renderer;

    public function __construct( Flexible_Product_Fields_Plugin $plugin, FPF_Product_Fields $product_fields, Renderer $renderer ) {
    	$this->plugin = $plugin;
    	$this->product_fields = $product_fields;
		$this->renderer = $renderer;
    	$this->hooks();
    }

    public function hooks() {
	    add_action( 'init', array( $this, 'register_post_types' ), 20);
	    add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 30 );

	    add_filter( 'manage_edit-fpf_fields_columns', array( $this, 'manage_edit_fpf_fields_columns' ), 11 );
	    add_action( 'manage_fpf_fields_posts_custom_column' , array( $this, 'manage_fpf_fields_posts_custom_column' ), 11 );

	    add_filter( 'post_row_actions', array( $this, 'post_row_actions' ), 10, 2 );

	    add_filter( 'bulk_actions-edit-fpf_fields', array( $this, 'bulk_actions' ) );

	    add_action( 'admin_menu', array( $this, 'admin_menu' ), 9999 );
	}

    /**
     * Register post types.
     */
    public function register_post_types() {

        if ( post_type_exists('fpf_fields') ) {
            return;
        }

        register_post_type( 'fpf_fields',
            array(
                'labels'              => array(
                    'name'                => __('Fields Groups', 'flexible-product-fields'),
                    'singular_name'       => __('Product Fields', 'flexible-product-fields'),
                    'menu_name'           => __('Product Fields', 'flexible-product-fields'),
                    'parent_item_colon'   => '',
                    'all_items'           => __('Product Fields', 'flexible-product-fields'),
                    'view_item'           => __('View Product Fields', 'flexible-product-fields'),
                    'add_new_item'        => __('Add new Fields Group', 'flexible-product-fields'),
                    'add_new'             => __('Add New', 'flexible-product-fields'),
                    'edit_item'           => __('Edit Fields Group', 'flexible-product-fields'),
                    'update_item'         => __('Save Fields Group', 'flexible-product-fields'),
                    'search_items'        => __('Search Fields Group', 'flexible-product-fields'),
                    'not_found'           => __('Fields Group not found', 'flexible-product-fields'),
                    'not_found_in_trash'  => __('Fields Group not found in trash', 'flexible-product-fields')
                ),
                'description'         => __( 'Product Fields.', 'flexible-product-fields' ),
                'public'              => false,
                'show_ui'             => true,
                'capability_type'     => 'post',
                'capabilities'        => array(),
                'map_meta_cap'        => true,
                'publicly_queryable'  => false,
                'exclude_from_search' => true,
                'hierarchical'        => false,
                'query_var'           => true,
                'supports'            => array( 'title' ),
                'has_archive'         => false,
                'show_in_nav_menus'   => false,
//                'show_in_menu'		  => 'product',
            )
        );

    }

    public function manage_edit_fpf_fields_columns( $columns ) {
        $ret = array();
        foreach ( $columns as $key => $column ) {
            if ( $key == 'date' ) {
	            $ret['fpf_assign_to'] = __( 'Assign to', 'flexible-product-fields' );
                $ret['fpf_fields'] = __( 'Fields', 'flexible-product-fields' );
            }
            $ret[$key] = $column;
        }
        unset( $ret['date'] );
        return $ret;
    }

    public function manage_fpf_fields_posts_custom_column( $column ) {
		global $post;
		$assign_to_options = [
			'product'  => [
				'label'           => __( 'Product', 'flexible-product-fields' ),
				'values_callback' => function() use ( $post ) {
					$values = get_post_meta( $post->ID, '_product_id', false ) ?: [];
					$labels = [];
					foreach ( $values as $product_id ) {
						$product  = get_post( $product_id );
						if ( $product !== null ) {
							$labels[] = $product->post_title;
						}
					}
					return $labels;
				},
			],
			'category'  => [
				'label'           => __( 'Category', 'flexible-product-fields' ),
				'values_callback' => function() use ( $post ) {
					$values = get_post_meta( $post->ID, '_category_id', false ) ?: [];
					$labels = [];
					foreach ( $values as $category_id ) {
						$category = get_term( $category_id );
						if ( $category !== null ) {
							$labels[] = $category->name;
						}
					}
					return $labels;
				},
			],
			'tag'  => [
				'label'           => __( 'Tag', 'flexible-product-fields' ),
				'values_callback' => function() use ( $post ) {
					$values = get_post_meta( $post->ID, '_tag_id', false ) ?: [];
					$labels = [];
					foreach ( $values as $tag_id ) {
						$tag      = get_term( $tag_id );
						if ( $tag !== null ) {
							$labels[] = $tag->name;
						}
					}
					return $labels;
				},
			],
			'all'  => [
				'label'           => __( 'All products', 'flexible-product-fields' ),
				'values_callback' => function() use ( $post ) {
					return null;
				},
			],
		];

    	switch ( $column ) {
			case 'fpf_fields':
				$values = get_post_meta( $post->ID, '_fields', true ) ?: [];
				$labels = [];
				foreach ( $values as $value ) {
					if ( mb_strlen( $value['title'] ) > 64 ) {
						$labels[] = htmlentities( mb_substr( $value['title'], 0, 64 ) ) . '...';
					} else {
						$labels[] = htmlentities( $value['title'] );
					}
				}

				echo esc_html( implode( ', ', $labels ) );
				break;
			case 'fpf_assign_to':
        		$assign_to = get_post_meta( $post->ID, '_assign_to', true );
				if ( ! isset( $assign_to_options[ $assign_to ] ) ) {
					break;
				}

				$labels = call_user_func( $assign_to_options[ $assign_to ]['values_callback'] ) ;
				if ( $labels === null ) {
					echo wp_kses_post( sprintf(
						'<strong>%s</strong>',
						$assign_to_options[ $assign_to ]['label']
					) );
				} else {
					echo wp_kses_post( sprintf(
						'<strong>%s</strong>:<br>%s',
						$assign_to_options[ $assign_to ]['label'],
						implode( ', ', $labels )
					) );
				}
				break;
		}
    }


    public function add_meta_boxes() {
		if ( !is_flexible_products_fields_pro_active() ) {
			add_meta_box(
		    	'fpf_upgrade_now',
				__( 'Flexible Product Fields PRO', 'flexible-product-fields' ),
		   	 	array( $this, 'upgrade_now_meta_box_output' ),
		   		'fpf_fields',
		   		'side',
		    	'default'
	    	);
		}
	    add_meta_box(
		    'fpf_docs',
			__( 'Start Here', 'flexible-product-fields' ),
		    array( $this, 'start_here_meta_box_output' ),
		    'fpf_fields',
		    'side',
		    'default'
	    );
    }

	public function upgrade_now_meta_box_output() {
		$this->renderer->output_render(
			'metabox/upgrade-now',
			[
				'is_native_box' => true
			]
		);
	}

    public function start_here_meta_box_output() {
		$this->renderer->output_render(
			'metabox/start-here',
			[
				'is_native_box' => true
			]
		);
    }

    public function admin_menu() {
	    remove_menu_page( 'edit.php?post_type=fpf_fields' );
	    add_submenu_page(
	        'edit.php?post_type=product',
            __('Product Fields', 'flexible-product-fields'),
            __('Product Fields', 'flexible-product-fields'),
            'manage_options',
            'edit.php?post_type=fpf_fields'
        );
    }

	public function post_row_actions( $actions, $post ) {
		global $current_screen;
		if ( !empty( $current_screen ) && $current_screen->post_type == 'fpf_fields' ) {
			unset( $actions['inline hide-if-no-js'] );
		}
		return $actions;
    }

	function bulk_actions( $actions ){
		unset( $actions[ 'edit' ] );
		return $actions;
	}

}

