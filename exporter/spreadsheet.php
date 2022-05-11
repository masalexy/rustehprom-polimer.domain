<?php
// For CLI
ini_set('memory_limit', -1);
$_SERVER['SERVER_NAME'] = 'rustehprom-polimer.ru';
$_SERVER['HTTP_HOST'] = 'rustehprom-polimer.ru';
define('WP_DEBUG', true);

require __DIR__ . '/../wp-load.php';
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

global $spreadsheet;
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$products = wc_get_products([
    'status' => 'publish',
    'limit' => -1
]);

$sheet->getColumnDimension('A')->setWidth(15);

$sheet->setCellValue('A1', 'Картинка');
$sheet->setCellValue('B1', 'Название');
$sheet->setCellValue('C1', 'Ссылка');
$sheet->setCellValue('D1', 'Цена');
$sheet->setCellValue('E1', 'ID товара');
$sheet->setCellValue('F1', 'Артикул');

$row = 2;
$maxImageColumnWidth = 105;
$dpi18 = 0.1411111111111111;
$offsetY = 2.5;
$preLetter = '';
$freeColumn = "G";
$accessoriesHeading = [];

foreach($products as $product){
    $id = $product->get_id();
    $sku = $product->get_sku();
    $title = $product->get_name();
    $price = $product->get_price();
    $image = wp_get_attachment_url($product->get_image_id());
    $permalink = urldecode($product->get_permalink());

    echo '#' . $id . ' ' . $title . "\n";

    if( $product->is_type('variable') ){
        $offsetX = 2.5;
        $variations = $product->get_available_variations();
        foreach($variations as $variation){
            $variation_image = $variation['image']['url'];
            $size = getimagesize($variation_image);
            driveImage($variation_image, "A{$row}", $offsetX);
            $aspectRatio = 100 / $size[1];
            $offsetX += ($aspectRatio * $size[0]) + $offsetY;
        }
        $maxImageColumnWidth = $maxImageColumnWidth < $offsetX ? $offsetX : $maxImageColumnWidth;
    }else{
        driveImage($image, "A{$row}");
    }

    $sheet->setCellValue("B{$row}", $title);
    $sheet->setCellValue("C{$row}", $permalink);
    $sheet->setCellValue("D{$row}", $price);
    $sheet->setCellValue("E{$row}", $id);
    $sheet->setCellValue("F{$row}", $sku);

    $row++;
}

function driveImage($url, $coordinate, $offsetX = 2.5){
    global $spreadsheet;

    $extension = pathinfo($url, PATHINFO_EXTENSION);
    $gdImage = ($extension == 'png') ? imagecreatefrompng($url) : imagecreatefromjpeg($url);

    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing();
    $drawing->setName('Paid');
    $drawing->setDescription('Paid');
    $drawing->setImageResource($gdImage);
    $drawing->setCoordinates($coordinate);
    $drawing->setOffsetX($offsetX);
    $drawing->setoffsetY(2.5);
    $drawing->setHeight(100);
    $drawing->setWorksheet($spreadsheet->getActiveSheet());
}

$maxImageColumnWidth += $offsetY;
$sheet->getDefaultRowDimension()->setRowHeight(80);
$sheet->getColumnDimension('A')->setWidth(30);


/* ================================== */


$writer = new Xlsx($spreadsheet);
$writer->save('files/products.xlsx');

echo "File saved successfully \n";
