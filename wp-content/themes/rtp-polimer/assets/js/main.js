jQuery(document).ready(function(){
    jQuery('input[type="tel"]').mask("+7 (999) 999-99-99");

    jQuery('.main-popup__close').click(function(){
        jQuery('body').removeClass('notScroll');
        jQuery(this).closest('.container_main-popup').find('.wpcf7-response-output, .wpcf7-not-valid-tip').hide();
        jQuery(this).closest('.container_main-popup').removeClass('show');
    });

    jQuery('.container_main-popup').click(function(e){
        if( !jQuery(e.target).closest('.main-popup').hasClass('main-popup') ){
            jQuery(this).find('.main-popup__close').click();
        }
    });

    jQuery(document).on('click', '.button-minus', function(){
    	let input = jQuery(this).next('input');
    	let qty = parseInt(input.val());
    	qty = (qty != 1) ? qty - 1 : 1;
    	input.val(qty).change();
    });

    jQuery(document).on('click', '.button-plus', function(){
    	let input = jQuery(this).prev('input');
    	let qty = parseInt(input.val()) + 1;
    	input.val(qty).change();
    });

    jQuery(document).on('click', '.product-cart__photo:not(.active)', function(){
    	let src = jQuery(this).find('img').attr('src');
    	jQuery('.woo-single-attachment').attr('src', src);
    	jQuery('.product-cart__photo').removeClass('active');
    	jQuery(this).addClass('active');
    });

    jQuery(document).on('click', '.product-cart__photo.active', function(){
        jQuery(this).removeClass('active');
        let src = jQuery('.woo-single-attachment').attr('source');
        jQuery('.woo-single-attachment').attr('src', src);
    });

    jQuery(document).unbind('click').bind('click', '.mobile-view .header-main-menu .menu-item-has-children', function(e){
        console.log( jQuery(e.target)  );
    	jQuery(e.target).closest('.menu-item-has-children').toggleClass('mv-active');
    });

    jQuery('.catalog-filters__view-plate').click(function(){
        jQuery('.active_catalog_view').removeClass('active_catalog_view');
        jQuery(this).addClass('active_catalog_view');
        jQuery('.products-catalog').removeClass('product-full');
    });
    jQuery('.catalog-filters__view-list').click(function(){
        jQuery('.active_catalog_view').removeClass('active_catalog_view');
        jQuery(this).addClass('active_catalog_view');
        jQuery('.products-catalog').addClass('product-full');
    });
    jQuery('#whv_wdgt').click(function(){
        ym(28694586,'reachGoal','wtc');
    });

});

let mobileView = function(){
    let nav = document.querySelector('.header__nav');
    let active_li = document.querySelector('.mv-active');
    if( parseInt(document.body.clientWidth) < 721 ){
        document.body.classList.add('mobile-view');
    }else{
        document.body.classList.remove('mobile-view');
        nav.classList.remove('header__nav_fixed');
        if(active_li) active_li.classList.remove('mv-active');
    }
}
window.addEventListener("load", mobileView);
window.addEventListener("resize", mobileView);

/* Range Slider Init */
var $rSlider = document.querySelector('.range-slider-raschet');
var $rValue = document.getElementById('raschet-val');
if($rSlider){
    var initVals = new Powerange($rSlider, {
        min: parseInt($rSlider.min),
        max: parseInt($rSlider.max),
        start: parseInt($rSlider.min),
        callback: function(){
            $rValue.innerHTML = $rSlider.value;
        }
    });
}


window.wpjshooks = {};
wpjshooks.set_form_values = function(id, args = {}){
    let $form = jQuery(`#${id}`).find('form');
    $form.find('input[name="productTitle"]').val(args.productTitle);
    $form.find('input[name="productPrice"]').val(args.productPrice);
    $form.find('input[name="productLink"]').val(args.productLink);

    $form.find('input[name="serviceTitle"]').val(args.serviceTitle);
    $form.find('input[name="serviceLink"]').val(args.serviceLink);

    this.popup(id);
}
wpjshooks.popup = function(id){
    jQuery(`#${id}`).addClass('show');
    jQuery('body').addClass('notScroll');
}


toggleMobileNav();
function toggleMobileNav() {
    let burger = document.querySelector('.header__burger');
    let nav = document.querySelector('.header__nav');
    let close = document.querySelector('.header__close');

    burger.addEventListener('click', () => {
        nav.classList.add('header__nav_fixed');
    });

    close.addEventListener('click', () => {
        nav.classList.remove('header__nav_fixed');
    });

}
toggleFixedNav();
function toggleFixedNav () {
    let menuBar = document.querySelector('.header__top');

    document.addEventListener('scroll', (event) => {
        let scrollTop = window.pageYOffset;

        if(scrollTop >= 200) {
            menuBar.classList.add('header__top_fixed');
            menuBar.parentNode.style.paddingTop = menuBar.clientHeight + 'px';
        }
        else {
            menuBar.classList.remove('header__top_fixed');
            menuBar.parentNode.style.paddingTop = '0';
        }
    });
}





// drang and drop
let dropContainers = document.getElementsByClassName('dropContainer');
for(let dropContainer of dropContainers){
	let fileInput = dropContainer.querySelector('input.user-file');
	let fileInputLabel = dropContainer.querySelector('.fileInputLabel');

	dropContainer.ondragover = dropContainer.ondragenter = function(evt) {
		evt.preventDefault();
		dropContainer.classList.add('draging');
	}
	dropContainer.ondrop = function(evt) {
		evt.preventDefault();
		dropContainer.classList.remove('draging');
	    fileInput.files = evt.dataTransfer.files;
		fileInput.onchange();
	}
	fileInput.onchange = function(e){
		if(fileInput.files.length > 0){
			let label = '';
			let title = [];
			if(fileInput.files.length < 2){
				label = '1 файл';
			}else if(fileInput.files.length < 5){
				label =  fileInput.files.length + ' файл';
			}else{
				label =  fileInput.files.length + ' файлов';
			}
			for(file of fileInput.files){
				title.push(file.name);
			}
			fileInputLabel.innerText = label;
			fileInputLabel.setAttribute('title', title.join(', '));
		}else{
			fileInputLabel.innerText = fileInputLabel.getAttribute('data-title');
			fileInputLabel.setAttribute('title', 'Нажмите обзор или перетащите файл сюда');
		}
	}
}


let contactFormNodes = document.querySelectorAll( '.wpcf7' );
for(let i = 0; i < contactFormNodes.length; i++){
	contactFormNodes[i].addEventListener('wpcf7submit', function( event ) {
		if( event.detail.status == 'mail_sent' ){
			jQuery('.fileInputLabel').text(jQuery('.fileInputLabel').data('title'));
			jQuery('.fileInputLabel').attr('title', jQuery('.fileInputLabel').data('title'));

            if(event.detail.contactFormId == "2216"){
                ym(28694586,'reachGoal','speed')
            }else if(event.detail.contactFormId == "2423"){
                ym(28694586,'reachGoal','speed2')
            }else if(event.detail.contactFormId == "2287"){
                ym(28694586,'reachGoal','speed3')
            }else if(event.detail.contactFormId == "2345"){
                ym(28694586,'reachGoal','zrc')
            }
		}
	}, false );
}
