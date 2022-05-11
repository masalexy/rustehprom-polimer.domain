window.addEventListener('load',function(){
	let base = window.location.origin + window.location.pathname;
	let category_form = document.getElementById('category_form');
	let region_form = document.getElementById('region_form');
	let list_form = document.getElementById('list_form');
	let inputs = document.getElementsByClassName('ajax_field');
	let notice = document.getElementById('notice');


	if(category_form){
		category_form.addEventListener('change',function(e){
			this.closest('form').submit();
		});
	}

	region_form.addEventListener('change',function(e){
		this.closest('form').submit();
	});

	list_form.addEventListener('change',function(e){
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

		fetch('/wp-content/plugins/multiregion/modules/pricelist/inc/update.php',{
			method: 'POST',
			body: data
		}).then((res) => {
			return res.text();
		}).then((data) => {
			this.classList.remove('waiting');

			if(data == 1){
				this.classList.add('completed');
				this.setAttribute('save', 'false');
			}else{
				this.classList.add('failed');
				message(data);
			}
		});
	};

	for(let i = 0; i < inputs.length; i++){
		inputs[i].addEventListener('blur', update);
		inputs[i].addEventListener('keyup', function(e){
			let code = e.which || e.keyCode;
			if(code == 13)
				this.blur();
			else
				this.setAttribute('save', 'true');
		});

		if(inputs[i].type == 'select-one'){
			inputs[i].setAttribute('save', 'true');
			inputs[i].addEventListener('change', update);
		}
	};

});
