<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(0);
date_default_timezone_set('Asia/Shanghai');
header("Content-Type:text/html;charset=utf-8");

require_once 'simplexlsx.class.php';    // xlsx: Excel 2007 or above


echo "<h1>条码信息采集系统</h1>";
echo "Start at " . date("Y-m-d H:i:s") . '<br />';
flush();

$originUrl = 'https://www.google.com.hk/search?ie=UTF-8&';
$excelFilePath = '2014.05.23.xlsx';
$data = new SimpleXLSX($excelFilePath);
list($columnNum, $rowNum) = $data->dimension();

$method = new Method();
$sheetData = $data->rows();

$count = 0;
$headerLine = 1200;
$step = 99;
for ($i = $headerLine; $i < $rowNum; $i++) {
    $row = $sheetData[$i];
    // $productName = $row[0];
    $barcode = $row[0];
    $url = $originUrl . "q=$barcode";
    if ($method->checkWebContent($url)) {
    	echo "第".($i+1)."行，查询获得信息：条码：$barcode, ".$url."<br>";
    	flush();
    }
    // $type = $row[2];
    // $num = $row[3];
    // $url = $row[6];
    // break;
    if ($i==($headerLine+$step)) {
		break;
    	sleep(2);
    }
}

echo "finished at " . date("Y-m-d H:i:s");
?>
