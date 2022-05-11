<?php
$get_cat_id = ( isset($_GET['cat_id']) ) ? $_GET['cat_id'] : 830;
echo '<div class="categories">Категории: <select name="cat_id" id="category_form">';
$categories = get_terms(['taxonomy' => 'product_cat', 'exclude' => [37,38], 'parent' => 0 ]);
$first = 830;

function get_childrens($id, $sep){
	global $get_cat_id;

	$sep .= '―';
	$categories = get_terms(['taxonomy' => 'product_cat', 'parent' => $id ]);
	if( !empty( $categories ) ){
		foreach($categories as $cat){
			$selected = ($get_cat_id == $cat->term_id) ? 'selected' : '';
			echo '<option value="'.$cat->term_id.'" '.$selected.'>'.$sep.' '.$cat->name . '</option>';
			get_childrens($cat->term_id,$sep);
		}

	}
}

foreach( $categories as $cat ){
	$selected = ($get_cat_id == $cat->term_id) ? 'selected' : '';
	echo '<option value="'.$cat->term_id.'" '.$selected.'>'.$cat->name . '</option>';
	echo get_childrens($cat->term_id, '');
}
echo '</select></div>';
?>
