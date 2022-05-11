window.addEventListener('load',function(){
	let search_time;
	let base = window.location.origin + window.location.pathname;
	let progress_loader = document.querySelector('.progress-loader');
	let category_form = document.getElementById('category_form');
	let region_clone_form = document.getElementById('region_clone_form');
	let live_search = document.getElementById('live_search');
	let region_form = document.getElementById('region_form');
	let feed_form = document.getElementById('feed_form');
	let inputs = document.getElementsByClassName('ajax_field');
	let notice = document.getElementById('notice');
	let load_products = document.getElementById('load-products');
	let load_products_gif = document.getElementById('p_loader_gif');
	let load_products_container = document.getElementById('products-load-container');

	let add_products = document.querySelector('.add_products');
	let products_modal = document.querySelector('.products-modal');
	let editor_modal_close = document.querySelectorAll('.editor-modal-close');

	let load_mode = document.querySelectorAll('.load-mode');
	let add_to_feed = document.getElementById('add_to_feed');
	let check_all = document.getElementById('check_all');
	let uncheck_all = document.getElementById('uncheck_all');

	let remove_product_items = document.querySelectorAll('.remove-product-item');
	let default_settings_items = document.querySelectorAll('.def-set-item');

	region_form.addEventListener('change',function(e){
		this.closest('form').submit();
	});

	feed_form.addEventListener('change',function(e){
		this.closest('form').submit();
	});

	let message = function(message){
		notice.getElementsByTagName('span')[0].innerText = message;
		notice.style.display = 'block';
	}

	notice.getElementsByTagName('i')[0].addEventListener('click',function(){
		notice.style.display = 'none';
	})

	let update = function(e){
		if(this.getAttribute('save') == 'false') return;
		this.classList.remove('failed');
		this.classList.remove('completed');

		this.classList.add('waiting');
		let args = {
			id: this.id,
			value: this.value,
			name: this.name,
			region_id: this.closest('table').getAttribute('region')
		};

		let data = new FormData();
		data.append( "update_data", JSON.stringify( args ) );

		fetch('/wp-content/plugins/feed-platform/editor/inc/update.php',{
			method: 'POST',
			body: data
		}).then((res) => {
			return res.text();
		}).then((data) => {
			this.classList.remove('waiting');

			if(data == 1){
				this.classList.add('completed');
				if(this.type != 'select-one')
					this.setAttribute('save', 'false');
			}else{
				this.classList.add('failed');
				message(data);
			}
		});
	};

	for(let i = 0; i < inputs.length; i++){
		if(inputs[i].type == 'select-one'){
			inputs[i].setAttribute('save', 'true');
			inputs[i].addEventListener('change', update);
		}else{
			inputs[i].addEventListener('blur', update);
			inputs[i].addEventListener('keyup', function(e){
				let code = e.which || e.keyCode;
				if(code == 13)
					this.blur();
				else
					this.setAttribute('save', 'true');
			});
		}
	};

	add_products.addEventListener('click',function(e){
		products_modal.classList.remove('hidden');
	});
	for(let close of editor_modal_close){
		close.addEventListener('click',function(e){
			this.closest('.editor-modal').classList.add('hidden');
		});
	}

	for(let mode of load_mode){
		mode.addEventListener('click',function(e){
			let selects = document.querySelectorAll('.select-load-mode');
			for(let select of selects){
				select.classList.add('hidden');
			}
			document.querySelector('.select-' + this.value).classList.remove('hidden');
			document.querySelector('.modes').setAttribute('mode', this.value);

		});
	}

	load_products.addEventListener('click',function(e){
		let mode = document.querySelector('.load-mode:checked').value;
		let value = (mode == 'feed') ? region_clone_form.value : category_form.value;
		let data = new FormData();
		data.append("mode", mode );
		data.append("value", value );
		data.append("gorod", window.feedParams.current_gorod );
		data.append("feed", window.feedParams.current_feed );
		load_products_container.innerHTML = '';
		load_products_gif.classList.remove('hidden');
		fetch('/wp-content/plugins/feed-platform/editor/inc/update.php',{
			method: 'POST',
			body: data
		}).then((res) => {
			return res.json();
		}).then((data) => {
			if(data){
				for(let product of data){
					let card = create_product_card(product);
					load_products_container.appendChild(card);
				}
			}
			load_products_gif.classList.add('hidden');
		});
	});

	function create_product_card(product){
		var p_checkbox = document.createElement("INPUT");
		p_checkbox.setAttribute("type", "checkbox");
		p_checkbox.setAttribute("class", "p_cart_item");
		p_checkbox.setAttribute("value", product.id);
		var p_label = document.createElement("LABEL");
		p_label.classList.add('product-card');
		var p_label_title = document.createTextNode(product.title);
		p_label.appendChild(p_checkbox);
		p_label.appendChild(p_label_title);
		return p_label;
	}

	check_all.addEventListener('click',function(e){
		let checkboxes = document.getElementsByClassName('p_cart_item');
		for(let checkbox of checkboxes){
			checkbox.checked = true;
		}
	});
	uncheck_all.addEventListener('click',function(e){
		let checkboxes = document.getElementsByClassName('p_cart_item');
		for(let checkbox of checkboxes){
			checkbox.checked = false;
		}
	});
	add_to_feed.addEventListener('click',function(e){
		let ids = [];
		let checkboxes = document.querySelectorAll('.p_cart_item:checked');
		console.log(checkboxes);
		for(let checkbox of checkboxes){
			ids.push(checkbox.value);
		}
		if(ids.length !== 0){
			progress_loader.classList.remove('hidden');
			let data = new FormData();
			data.append("post_ids", ids );
			data.append("gorod", window.feedParams.current_gorod );
			data.append("feed", window.feedParams.current_feed );
			fetch('/wp-content/plugins/feed-platform/editor/inc/update.php',{
				method: 'POST',
				body: data
			}).then((res) => {
				return res.json();
			}).then((data) => {
				if(data.status == "SUCCESS"){
					window.location.reload();
				}else{
					progress_loader.classList.add('hidden');
					message(data.status);
				}
			});
		}
	});

	for(let rp_item of remove_product_items){
		rp_item.addEventListener('click',function(e){
			let confirm_alert = confirm('Подтвердите удаление');
			if(confirm_alert){
				progress_loader.classList.remove('hidden');
				let id = rp_item.value;
				let data = new FormData();
				data.append("rm_post_id", id );
				data.append("gorod", window.feedParams.current_gorod );
				data.append("feed", window.feedParams.current_feed );
				fetch('/wp-content/plugins/feed-platform/editor/inc/update.php',{
					method: 'POST',
					body: data
				}).then((res) => {
					return res.json();
				}).then((data) => {
					if(data.status == "SUCCESS"){
						rp_item.closest('.row-line').remove();
					}else{
						message(data.status);
					}
					progress_loader.classList.add('hidden');
				});
			}
		});
	}

	let updateDefaultSettings = function (e){
		let field = e.target;
		let args = {
			name: field.name,
			value: field.value,
			gorod: window.feedParams.current_gorod,
			feed: window.feedParams.current_feed
		};
		let data = new FormData();
		data.append("def_settings", JSON.stringify( args ) );
		progress_loader.classList.remove('hidden');
		fetch('/wp-content/plugins/feed-platform/editor/inc/update.php',{
			method: 'POST',
			body: data
		}).then((res) => {
			return res.text();
		}).then((data) => {
			progress_loader.classList.add('hidden');
		});
	}

	for(let item of default_settings_items){
		if(item.type == 'select-one'){
			item.addEventListener('change', updateDefaultSettings);
		}else{
			item.addEventListener('blur', updateDefaultSettings);
			item.addEventListener('keyup', function(e){
				let code = e.which || e.keyCode;
				if(code == 13) this.blur();
			});
		}
	}




	let generate_by_keyword = function(keyword){
		let data = new FormData();
		data.append("post_keyword", keyword );
		load_products_container.innerHTML = '';
		load_products_gif.classList.remove('hidden');
		fetch('/wp-content/plugins/feed-platform/editor/inc/update.php',{
			method: 'POST',
			body: data
		}).then((res) => {
			return res.json();
		}).then((data) => {
			load_products_container.innerHTML = '';
			for(let product of data){
				let card = create_product_card({
					id: product.ID,
					title: product.post_title
				});
				load_products_container.appendChild(card);
			}
			load_products_gif.classList.add('hidden');
		});
	}

	live_search.addEventListener('keyup', function(e){
		if( this.value.length > 2 ){
			let keyword = this.value;
			if(search_time){
				clearTimeout(search_time);
			}
			search_time = setTimeout(function(){
				generate_by_keyword(keyword);
			}, 1000);
		}
	});



});
