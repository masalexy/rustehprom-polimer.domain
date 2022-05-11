<?php
$dir = opendir(__DIR__); $inc_file = '/index.php';
while (false !== ($name = readdir($dir))) {
    $file =  __DIR__.'/'.$name.$inc_file;
    if ($name != "." && $name != ".." && file_exists($file ) ) {
        include($file);
    }

}
closedir($dir);
