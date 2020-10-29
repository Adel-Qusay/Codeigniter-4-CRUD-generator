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

require('config.php');
$p = isset($_GET['p']) ? $_GET['p'] : '';

switch ( $p ) {	
  case 'generator':
    $data = array();
	$data['title'] = 'ADEL CI4 CRUD GENERATOR';
	$data['databases'] = $engine->getDatabases();
    $viewLoader->load_template('generator', $data);
    break;	
  default:
    $data = array();
	$data['title'] = 'ADEL CI4 CRUD GENERATOR';	
    $viewLoader->load_template('home', $data);
}
?>
