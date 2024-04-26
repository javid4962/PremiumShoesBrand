<?php

class Whizzie {

	public function __construct() {
		$this->init();
	}

	public function init()
	{
	
	}

	public static function shoes_store_elementor_setup_widgets(){

	$shoes_store_elementor_product_image_gallery = array();
	$shoes_store_elementor_product_ids = array();

	$shoes_store_elementor_product_category= array(
		'Product Category'       => array(
			'Nike Kyrie 7 TB Midnight',
			'Preventing Sneaker Bots',
			'RS X CNV Sneakers',
			'Cali Kari Sneakers',
		),
	);

	$shoes_store_elementor_k = 1;
	foreach ( $shoes_store_elementor_product_category as $shoes_store_elementor_product_cats => $shoes_store_elementor_products_name ) { 
	// Insert porduct cats Start
	$content = 'This is sample product category';
	$shoes_store_elementor_parent_category	=	wp_insert_term(
	$shoes_store_elementor_product_cats, // the term
	'product_cat', // the taxonomy
		array(
		'description'=> $content,
		'slug' => str_replace( ' ', '-', $shoes_store_elementor_product_cats)
		)
	);

// -------------- create subcategory END -----------------

	$shoes_store_elementor_n=1;
	// create Product START
	foreach ( $shoes_store_elementor_products_name as $key => $shoes_store_elementor_product_title ) {
	$content = '
		<div class="main_content">
		<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
		</div>';

	// Create post object
	$shoes_store_elementor_my_post = array(
		'post_title'    => wp_strip_all_tags( $shoes_store_elementor_product_title ),
		'post_content'  => $content,
		'post_status'   => 'publish',
		'post_type'     => 'product',
		'post_category' => [$shoes_store_elementor_parent_category['term_id']]
	);

	// Insert the post into the database

	$shoes_store_elementor_uqpost_id = wp_insert_post($shoes_store_elementor_my_post);
	wp_set_object_terms( $shoes_store_elementor_uqpost_id, str_replace( ' ', '-', $shoes_store_elementor_product_cats), 'product_cat', true );

	$shoes_store_elementor_price = array('600','600','600','600');
	$shoes_store_elementor_regular_price = array('600','600','600','600');
	$shoes_store_elementor_sale_price = array('400','400','400','400');
	
	update_post_meta( $shoes_store_elementor_uqpost_id, '_price', $shoes_store_elementor_price[$shoes_store_elementor_n-1] );
	update_post_meta( $shoes_store_elementor_uqpost_id, '_regular_price', $shoes_store_elementor_regular_price[$shoes_store_elementor_n-1] );
	update_post_meta( $shoes_store_elementor_uqpost_id, '_sale_price', $shoes_store_elementor_sale_price[$shoes_store_elementor_n-1] );
	array_push( $shoes_store_elementor_product_ids,  $shoes_store_elementor_uqpost_id );

	// Now replace meta w/ new updated value array
	$shoes_store_elementor_image_url = get_template_directory_uri().'/assets/images/product/'.$shoes_store_elementor_product_cats.'/' . str_replace(' ', '_', strtolower($shoes_store_elementor_product_title)).'.png';
	$shoes_store_elementor_image_name  = $shoes_store_elementor_product_title.'.png';
	$shoes_store_elementor_upload_dir = wp_upload_dir();
	// Set upload folder
	$shoes_store_elementor_image_data = file_get_contents(esc_url($shoes_store_elementor_image_url));
	// Get image data
	$unique_file_name = wp_unique_filename($shoes_store_elementor_upload_dir['path'], $shoes_store_elementor_image_name);
	// Generate unique name
	$shoes_store_elementor_filename = basename($unique_file_name);
	// Create image file name
	// Check folder permission and define file location
	if (wp_mkdir_p($shoes_store_elementor_upload_dir['path'])) {
	$shoes_store_elementor_file = $shoes_store_elementor_upload_dir['path'].'/'.$shoes_store_elementor_filename;
	} else {
	$shoes_store_elementor_file = $shoes_store_elementor_upload_dir['basedir'].'/'.$shoes_store_elementor_filename;
	}
	
	file_put_contents($shoes_store_elementor_file, $shoes_store_elementor_image_data);
	// Check image file type
	$wp_filetype = wp_check_filetype($shoes_store_elementor_filename, null);
	// Set attachment data
	$attachment = array(
	'post_mime_type' => $wp_filetype['type'],
	'post_title'     => sanitize_file_name($shoes_store_elementor_filename),
	'post_type'      => 'product',
	'post_status'    => 'inherit',
	);

	// Create the attachment
	$shoes_store_elementor_attach_id = wp_insert_attachment($attachment, $shoes_store_elementor_file, $shoes_store_elementor_uqpost_id);

	// Define attachment metadata
	$attach_data = wp_generate_attachment_metadata($shoes_store_elementor_attach_id, $shoes_store_elementor_file);

	// Assign metadata to attachment
	wp_update_attachment_metadata($shoes_store_elementor_attach_id, $attach_data);
	if ( count( $shoes_store_elementor_product_image_gallery ) < 3 ) {
		array_push( $shoes_store_elementor_product_image_gallery, $shoes_store_elementor_attach_id );
	}
	// // And finally assign featured image to post
	set_post_thumbnail($shoes_store_elementor_uqpost_id, $shoes_store_elementor_attach_id);
	++$shoes_store_elementor_n;
	}
	// Create product END
	++$shoes_store_elementor_k;
	}
	// Add Gallery in first simple product and second variable product START
	$shoes_store_elementor_product_image_gallery = implode( ',', $shoes_store_elementor_product_image_gallery );
	foreach ( $shoes_store_elementor_product_ids as $shoes_store_elementor_product_id ) {
	update_post_meta( $shoes_store_elementor_product_id, 'shoes_store_elementor_product_image_gallery', $shoes_store_elementor_product_image_gallery );
	}
}

}
 