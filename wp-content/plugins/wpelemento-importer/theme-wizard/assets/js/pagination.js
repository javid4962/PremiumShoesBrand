jQuery(document).ready(function($) {
    
    $('.template_pagination').on('click', function(e) {

        $('.main-grid-card-parent-pulse').show();
        $('.main-grid-card-overlay').show();

        var paged = $('[name="load_more"]').val();
        const search_val = $('[name="search_themes"]').val();
        const category_id = $('.dropdown-item.templates.selected').attr('data-category');

        $this = $(this);

        $.ajax({
            url: wpelemento_importer_pro_whizzie_params.ajaxurl,
            type: 'POST',
            data: {
              action: 'pagination_load_content',
              paged: paged,
              search_val: search_val,
              category_id: category_id
            },
            success: function(response) {

                $('.main-grid-card-parent-pulse').hide();
                $('.main-grid-card-overlay').hide();
                
                if ( response.code == 200 && response.data.length ) {

                    var next_page = parseInt(paged)+1;

                    if (next_page == response.total_pages ) {
                        $this.hide();    
                    } else {
                        $('[name="load_more"]').val( next_page );
                    }

                    response.data.forEach((theme, i) => {
                        $('.main-grid-card.row.theme-templates').append(`
                            <div class="main-grid-card-parent col-lg-4 col-md-6 col-12">
                                <div class="main-grid-card-parent-inner">
                                    <div class="main-grid-card-parent-inner-image-head">
                                        <img class="main-grid-card-parent-inner-image" src="`+ theme.thumbnail_url +`" width="100" height="100" alt="`+ theme.get_the_title +`">
                                    </div>
                                    <div class="main-grid-card-parent-inner-description">
                                        <h3>`+ theme.get_the_title +`</h3>
                                        <div class="main-grid-card-parent-inner-button">
                                            <a target="_blank" href="`+ theme.product_permalink +`" class="main-grid-card-parent-inner-button-buy">Buy Now</a>
                                            <a target="_blank" href="`+ theme.live_demo +`" class="main-grid-card-parent-inner-button-preview">Demo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    });

    function templates_api_category_wise( category_id, search_val ) {

        $.ajax({
            url: wpelemento_importer_pro_whizzie_params.ajaxurl,
            type: 'POST',
            data: {
              action: 'templates_api_category_wise',
              paged: 1,
              category_id: category_id,
              search_val: search_val
            },
            success: function(response) {

                $('.main-grid-card-parent-pulse').hide();
                $('.main-grid-card-overlay').hide();
                
                if ( response.code == 200 && response.data.length ) {

                    var next_page = 1;

                    if (next_page == response.total_pages ) {
                        $('.template_pagination').hide();
                    } else {      
                        $('.template_pagination').show();
                        $('[name="load_more"]').val( next_page );
                    }
                    
                    $('.main-grid-card.row.theme-templates').empty();

                    response.data.forEach((theme, i) => {
                        $('.main-grid-card.row.theme-templates').append(`
                            <div class="main-grid-card-parent col-lg-4 col-md-6 col-12">
                                <div class="main-grid-card-parent-inner">
                                    <div class="main-grid-card-parent-inner-image-head">
                                        <img class="main-grid-card-parent-inner-image" src="`+ theme.thumbnail_url +`" width="100" height="100" alt="`+ theme.get_the_title +`">
                                    </div>
                                    <div class="main-grid-card-parent-inner-description">
                                        <h3>`+ theme.get_the_title +`</h3>
                                        <div class="main-grid-card-parent-inner-button">
                                            <a target="_blank" href="`+ theme.product_permalink +`" class="main-grid-card-parent-inner-button-buy">Buy Now</a>
                                            <a target="_blank" href="`+ theme.live_demo +`" class="main-grid-card-parent-inner-button-preview">Demo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    }

    jQuery('.main-grid-card.filter-templates .dropdown').on('click', function() {
        $('.main-grid-card.filter-templates .dropdown-toggle').dropdown();
    });

    function debounce(func, delay) {
        let timeoutId;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                func.apply(context, args);
            }, delay);
        };
    }    

    $('[name="search_themes"]').on('input', debounce(function() {
        const category_id = $('.dropdown-item.templates.selected').attr('data-category');
        const search_val = $(this).val();
    
        if (search_val.length > 2) {
            $('.main-grid-card-parent-pulse').show();
            $('.main-grid-card-overlay').show();
        }
    
        templates_api_category_wise(category_id, search_val);
    }, 300));

    $('.dropdown-item.templates').on('click', function(event) {
        event.preventDefault();
        
        $('.dropdown-item.templates').removeClass('selected');
        $(this).addClass('selected');

        const category_id = $(this).attr('data-category');
        const search_val = $('[name="search_themes"]').val();

        $('.main-grid-card-parent-pulse').show();
        $('.main-grid-card-overlay').show();

        templates_api_category_wise( category_id, search_val );
    });

    $('#themeCouponCode').click(function() {
        var couponCode = $(this).text();
        
        var tempInput = $("<input>");        
        $("body").append(tempInput);        
        tempInput.val(couponCode).select();
        document.execCommand("copy");        
        tempInput.remove();
        
        alert("Coupon code copied to clipboard: " + couponCode);
    });
});