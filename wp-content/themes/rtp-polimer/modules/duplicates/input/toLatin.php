<?php
require( $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php');
if( isset($_POST['toLatinWord']) ){
    $word = $_POST['toLatinWord'];
    $word = apply_filters('sanitize_title', $word);
    echo $word;
}
