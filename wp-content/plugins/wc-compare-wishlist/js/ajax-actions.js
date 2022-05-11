jQuery(document).ready(function() {

    jQuery(document).on('click', window.wc_compare_class, function(e){
        e.preventDefault();
        let button = jQuery(this);
        if(button.hasClass('added')){
            window.location = wc_compare_page_url;
        }else{
            // Ajax adding to list
            let product_id = button.data('id');
            button.addClass('waiting');
            jQuery.post(wcwl_url, {
                wc_compare_add_product: product_id
            }, function(data){
                if(data == 'SUCCESS')
                    button.addClass('added');
                button.removeClass('waiting');
            });
        }
    });



    jQuery(document).on('click', window.wc_wishlist_class, function(e){
        e.preventDefault();
        let button = jQuery(this);
        if(button.hasClass('added')){
            window.location = wc_wishlist_page_url;
        }else{
            // Ajax adding to list
            let product_id = button.data('id');
            button.addClass('waiting');
            jQuery.post(wcwl_url, {
                wc_wishlist_add_product: product_id
            }, function(data){
                if(data == 'SUCCESS')
                    button.addClass('added');
                button.removeClass('waiting');
            });

        }
    });

});
