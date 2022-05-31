<?php
/*
==========================================================================
                   ADEL CODEIGNITER 4 CRUD GENERATOR            
==========================================================================
برمجة وتطوير: عادل قصي
البريد الإلكتروني: adelbak2014@gmail.com
الموقع الرسمي: www.e-net.xyz
الصفحة الرسمية للمبرمج: https://www.facebook.com/adel.qusay.9
==========================================================================
*/

require 'config.php';

$t = (isset($_GET['t']) || $_GET['t'] != '') ? $_GET['t'] : ''; 
$f = (isset($_GET['f']) || $_GET['f'] != '') ? $_GET['f'] : ''; 

if ($t == 'c'){
	$folder = 'Controllers';
}elseif($t == 'm') {
	$folder = 'Models';	
}elseif($t == 'v') {
	$folder = 'Views';
}else{
	$folder = 'Controllers';
}

$file = DOWNLOADS .'/'.$folder.'/'.$f;

// Maximum size of chunks (in bytes).
$maxRead = 1 * 1024 * 1024; // 1MB

// Give a nice name to your download.
$fileName = pathinfo($file, PATHINFO_BASENAME);


// Open a file in read mode.
$fh = fopen($file, 'r');

// These headers will force download on browser,
// and set the custom file name for the download, respectively.
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $fileName . '"');

// Run this until we have read the whole file.
// feof (eof means "end of file") returns `true` when the handler
// has reached the end of file.
while (!feof($fh)) {
    // Read and output the next chunk.
    echo fread($fh, $maxRead);

    // Flush the output buffer to free memory.
    ob_flush();
}

// Exit to make sure not to output anything else.
exit;