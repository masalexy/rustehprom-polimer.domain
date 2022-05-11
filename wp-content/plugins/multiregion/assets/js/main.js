jQuery(document).ready(function(){

    jQuery('.search-region').keyup(function(){
    	let value = jQuery(this).val().toLowerCase();
    	jQuery('.region-item').each(function(){
    		let name = jQuery(this).data('search').toLowerCase();
    		if(name.includes(value)){
    			jQuery(this).show();
    		}else{
    			jQuery(this).hide();
    		}
    	});
    });

});
