<?php
add_action('admin_notices', 'premium_upsell_banner_admin_notice');
function premium_upsell_banner_admin_notice() {
    $theme = wp_get_theme();
    $theme_author = $theme->get('Author');

    $upsell_banner_html = '';
    if ( $theme_author == 'wpelemento' ) {
        $upsell_banner_html = premium_upsell_banner_notice_html();

        if ($upsell_banner_html != '') { ?>
            <div class="upsell-notice notice is-dismissible">
                <?php echo $upsell_banner_html; ?>
            </div>
        <?php }
    } ?>

<?php }

function premium_upsell_banner_notice_html(){

    $endpoint = WPEI_THEME_LICENCE_ENDPOINT . 'get_premium_upsell_banner_theme_details';
    $body = ['theme_text_domain' => wp_get_theme()->get('TextDomain') ];
    $body = wp_json_encode($body);
    $options = ['body' => $body, 'headers' => ['Content-Type' => 'application/json', ]];
    $response = wp_remote_post($endpoint, $options);

    $html = '';

    if (!is_wp_error($response)) {
        
        $response_body = wp_remote_retrieve_body($response);
        $response_body = json_decode($response_body);
        $currency_symbol = $response_body->currency_symbol;

        if (!empty($response_body->data)) {
            $product_data = $response_body->data[0];

            $product_title = $product_data->title;
            $product_price = $product_data->price;
            $product_permalink = $product_data->permalink;

            $final_price = $currency_symbol.''.$product_price;
            
            $html .= '<section class="ele-banner-main">
                <div class="ele-banner-main-content">
                    <h3 class="ele-banner-heading">Upgrade to Premium | Get 30% OFF</h3>
                    <p class="ele-banner-para">Try Our '.$product_title.' & Explore Some Additional Features At Just '.$final_price.' Use Coupon "<span class="ele-banner-coupon-code">WP30</span>"</p>
                    <div class="ele-banner-button">
                        <a class="ele-banner-pre-btn ele-premium" target="_blank" href="'.esc_url($product_permalink).'">Get Premium</a>
                        <a class="ele-banner-pre-btn ele-explore" target="_blank" href="'.esc_url(admin_url('admin.php?page=elemento-templates')).'">Explore More Templates</a>
                    </div>
                </div>
            </section>';

            return $html;
        }
        return $html;
    }

    return $html;

}

function enqueue_custom_admin_notice_styles() {
    wp_enqueue_style('custom-admin-notice-style', EDI_URL . 'assets/css/admin-notice-style.css');
    wp_enqueue_style('custom-font-notice-style', 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_notice_styles');