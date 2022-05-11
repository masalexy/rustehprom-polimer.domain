jQuery(document).ready(function(){
    jQuery('#add-feed-item').click(function(){
        let item = clonedFeedItem;
        jQuery('#feed-items-table').find('tbody').append(item);
    });

    jQuery(document).on('click', '.removeFeed', function(){
        jQuery(this).closest('tr').remove();
    });
});
