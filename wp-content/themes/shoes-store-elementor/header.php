<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Shoes Store Elementor
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta http-equiv="Content-Type" content="<?php echo esc_attr(get_bloginfo('html_type')); ?>; charset=<?php echo esc_attr(get_bloginfo('charset')); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.2, user-scalable=yes" />

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php
	if ( function_exists( 'wp_body_open' ) )
	{
		wp_body_open();
	}else{
		do_action('wp_body_open');
	}
?>
<?php if(get_theme_mod('shoes_store_elementor_preloader_hide','')){ ?>
	<div class="loader">
		<div class="preloader">
			<div class="diamond">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
<?php } ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'shoes-store-elementor' ); ?></a>
<header id="site-navigation" class="header text-center text-md-left">
	<div class="home-page-header">
		<div class="topheader">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-4 col-md-5 align-self-center">
						<div class="row">
							<?php if( get_theme_mod( 'shoes_store_elementor_google_translator') != '') { ?>
								<div class="col-lg-6 col-md-6 col-sm-12 px-1 border-right align-self-center">	
									<div class="translate-lang">
										<?php echo do_shortcode( '[gtranslate]' );?>
									</div>							
								</div>
							<?php } ?>
							<?php if( get_theme_mod( 'shoes_store_elementor_currency_switcher') != '') { ?>
								<div class="col-lg-3 col-md-3 col-sm-12 border-right px-1 align-self-center">				
										<?php if(class_exists('woocommerce')){ ?>
											<div class="currency-box">
												<?php echo do_shortcode('[woocs show_flags=0 txt_type="desc" style=3]'); ?>
											</div>
										<?php } ?>							
								</div>
							<?php }?>
							<?php if ( get_theme_mod('shoes_store_elementor_header_button_text') ) : ?>
								<div class="col-lg-3 col-md-3  col-sm-12 align-self-center head-btn text-center text-md-right align-self-center">	
									<a class="contact-button" href="<?php echo esc_url( get_theme_mod('shoes_store_elementor_header_button_url' ) ); ?>"><?php echo esc_html( get_theme_mod('shoes_store_elementor_header_button_text' ) ); ?></a>
								</div>
							<?php endif; ?>
						</div>
				    </div>
					<div class="col-lg-5 col-md-5 adver-text align-self-center">
						<?php if ( get_theme_mod('shoes_store_elementor_header_advertisement_text') ) : ?>
							<p class="mb-0 text-center"><?php echo esc_html( get_theme_mod('shoes_store_elementor_header_advertisement_text' ) ); ?></p>
						<?php endif; ?>
					</div>

				    <div class="col-lg-3 col-md-2 col-sm-12 align-self-center ">
					    <div class="row">
							<div class="col-lg-6 wish-list text-right col-6 align-self-center">
								<?php if ( get_theme_mod('shoes_store_elementor_header_wishlist_url') ) : ?>
									<a href="<?php echo esc_url( get_theme_mod('shoes_store_elementor_header_wishlist_url' ) ); ?>"><i class="far fa-heart"></i></a>
								<?php endif; ?>
							</div>
							<div class="col-lg-6 col-6 align-self-center text-left">
								<?php if ( get_theme_mod('shoes_store_elementor_cart_box_enable', 'on' ) == true ) : ?>
									<?php if ( class_exists( 'woocommerce' ) ) {?>
										<a class="cart-customlocation" href="<?php if(function_exists('wc_get_cart_url')){ echo esc_url(wc_get_cart_url()); } ?>" title="<?php esc_attr_e( 'View Shopping Cart','shoes-store-elementor' ); ?>"><i class="fas fa-shopping-bag"></i><span class="cart-item-box"><?php echo esc_html(wp_kses_data( WC()->cart->get_cart_contents_count() ));?></span></a>
									<?php }?>
								<?php endif; ?>
							</div>
						</div>
			        </div>
		        </div>
		    </div>
		</div>
		<div class="header py-2 <?php if( get_theme_mod( 'shoes_store_elementor_sticky_header','on') != '') { ?>sticky-header<?php } else { ?>close-sticky <?php } ?>">
			<div class="container-fluid">
				<div class="row mx-0">
					<div class="col-lg-2 col-md-3 col-sm-3 align-self-center">
						<div class="logo text-center text-md-left mb-3 mb-lg-0">
						    <div class="logo-image">
						    	<?php  the_custom_logo(); ?>
							</div>
							<div class="logo-content">
								<?php
									if ( get_theme_mod('shoes_store_elementor_display_header_title', true) == true ) :
										echo '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name')) . '">';
										echo esc_attr(get_bloginfo('name'));
										echo '</a>';
									endif;
									if ( get_theme_mod('shoes_store_elementor_display_header_text', false) == true ) :
										echo '<span>'. esc_attr(get_bloginfo('description')) . '</span>';
									endif;
								?>
							</div>
						</div>
					</div>
					<div class="col-lg-5 col-md-9 col-sm-7 align-self-center ">
						<button class="menu-toggle my-2 py-2 px-3" aria-controls="top-menu" aria-expanded="false" type="button">
							<span aria-hidden="true"><?php esc_html_e( 'Menu', 'shoes-store-elementor' ); ?></span>
						</button>
						<nav id="main-menu" class="close-panal">
							<?php
								wp_nav_menu( array(
									'theme_location' => 'main-menu',
									'container' => 'false'
								));
							?>
							<button class="close-menu my-2 p-2" type="button">
								<span aria-hidden="true"><i class="fa fa-times"></i></span>
							</button>
						</nav>
					</div>

					<div class="col-lg-3 col-md-6 align-self-center">
						<?php if( get_theme_mod( 'shoes_store_elementor_disable_search_icon', 'on' ) ){ ?>
							<div class="search-box">
								<?php if(class_exists('woocommerce')){
									get_product_search_form();
								} ?>
							</div>
						<?php } ?>
					</div>

	        		<div class="col-lg-2 my-account align-self-center col-md-6 text-md-center text-lg-left">
						<?php if(class_exists('woocommerce')){ ?>
							<?php if ( is_user_logged_in() ) { ?>
								<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('My Account','shoes-store-elementor'); ?>"><i class="fas fa-sign-in-alt mr-2"></i><?php esc_html_e('My Account','shoes-store-elementor'); ?><span class="screen-reader-text"><?php esc_html_e( 'My Account','shoes-store-elementor' );?></span></a>
							<?php }
							else { ?>
								<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('Login / Register','shoes-store-elementor'); ?>"><i class="fas fa-user mr-2"></i><?php esc_html_e('Login / Register','shoes-store-elementor'); ?><span class="screen-reader-text"><?php esc_html_e( 'Login / Register','shoes-store-elementor' );?></span></a>
							<?php } ?>
						<?php }?>
					</div>
				</div>
			</div>
	    </div>
    </div>
</header>
