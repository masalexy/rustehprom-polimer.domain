jQuery(document).on('click', '.duplicate_page_title .acf-input-append', function(){
	let $row = jQuery(this).closest('tr');
	let $titleInput = $row.find('.duplicate_page_title input');
	let $linkInput = $row.find('.duplicate_page_slug input');

	jQuery.post('/wp-content/themes/rtp-polimer/modules/duplicates/input/toLatin.php', {toLatinWord: $titleInput.val()}, function(data){
        if(data){
            $linkInput.val(data);
            $linkInput.trigger('input');
        }
    });
});


jQuery(document).on('input', '#product_duplicate_slug input', function(){
	let $input = jQuery(this);
	jQuery.post('/wp-content/themes/rtp-polimer/modules/duplicates/input/check-product-slug.php', {product_slug: $input.val()}, function(data){
        if(data == 'DISABLED'){
			$input.addClass('disabled_value');
		}else{
			$input.removeClass('disabled_value');
		}
		window.duplicate_page_slug = data;
    });
});



jQuery(document).on('input', '#taxonomy_duplicate_slug input', function(){
	let $input = jQuery(this);
	if($input.val() == ''){
		$input.removeClass('disabled_value');
		window.duplicate_page_slug = '';
		return;
	}
	let tax_type = ( jQuery('body').hasClass('taxonomy-product_cat') ) ? 'product_cat' : 'product_tag';
	let args = {
		slug: $input.val(),
		type: tax_type
	};

	jQuery.post('/wp-content/themes/rtp-polimer/modules/duplicates/input/check-taxonomy-slug.php', {tax_data:args}, function(data){
		console.log(data);
		if(data == 'DISABLED'){
			$input.addClass('disabled_value');
		}else{
			$input.removeClass('disabled_value');
		}
		window.duplicate_page_slug = data;
    });
});


jQuery('#edittag, #post').submit(function(e){
	if(window.duplicate_page_slug == 'DISABLED' && jQuery('.duplicate_page_slug input').length > 1){
		e.preventDefault();
		jQuery('html, body').animate({
			scrollTop: jQuery('.disabled_value').closest('table').offset().top
		}, 500, function(){
			jQuery('#duplicate_page_message').show();
		});
	}
	jQuery('#duplicate_page_message .acf-label').click(function(){
		jQuery('#duplicate_page_message').hide();
	})
});


jQuery(document).ready(function(){
	if(typeof tinymce != "undefined"){
		window.edMod = new tinymce.Editor('modat_editor', {
			width: 600,
			height: 300
		}, tinymce.EditorManager);
		edMod.render();
	}

	jQuery(document).on('dblclick', '.open_editor_modal input', function(){
		window.edModInput = jQuery(this);
		let value = jQuery(this).val();
		edMod.setContent(value);
		jQuery('.modal_editor_popup').show();
	});

	jQuery(document).on('click', '.modal_editor_popup .dashicons', function(){
		jQuery('.modal_editor_popup').hide();
	});

	jQuery(document).on('click', '#insert_modal_content', function(){
		let content = edMod.getContent();
		edModInput.val(content);
		jQuery('.modal_editor_popup').hide();
	});



});
