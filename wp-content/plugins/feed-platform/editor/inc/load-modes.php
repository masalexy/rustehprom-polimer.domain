<select class="select-load-mode select-site" id="category_form">
<?php
    $categories = get_terms(['taxonomy' => 'product_cat', 'exclude' => [], 'parent' => 0 ]);

    function get_childrens($id, $sep){
    	$sep .= '―';
    	$categories = get_terms(['taxonomy' => 'product_cat', 'parent' => $id ]);
    	if( !empty( $categories ) ){
    		foreach($categories as $cat){
    			echo '<option value="'.$cat->slug.'">'.$sep.' '.$cat->name . '</option>';
    			get_childrens($cat->term_id,$sep);
    		}

    	}
    }

    foreach( $categories as $cat ){
    	echo '<option value="'.$cat->slug.'">'.$cat->name . '</option>';
    	echo get_childrens($cat->term_id, '');
    }
?>
</select>

<?php global $all_regions; ?>
<select class="select-load-mode select-feed hidden" id="region_clone_form">
<?php foreach($all_regions as $region): ?>
    <?php if($_GET['region_id'] == $region->region_id || !isset($_GET['region_id'])) continue; ?>
    <option value="<?php echo $region->region_id; ?>"><?php echo $region->name; ?></option>
<?php endforeach; ?>
</select>

<div class="select-load-mode select-name hidden">
    <input type="text" id="live_search" placeholder="Введите ID или Название товара">
</div>


<button id="load-products">Загрузить</button>
