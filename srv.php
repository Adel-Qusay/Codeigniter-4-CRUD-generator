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
if (@$_SERVER['REQUEST_METHOD'] !== 'POST') die('0');

/*------------------------------------------------
              getTablesByDatabase 
--------------------------------------------------*/
if (isset($_POST['act']) && $_POST['act'] === 'getTablesByDatabase') {

    $engine->getTablesByDatabase($_POST);
}

/*------------------------------------------------
              getColumnsByTable 
--------------------------------------------------*/
if (isset($_POST['act']) && $_POST['act'] === 'getColumnsByTable') {

    $engine->getColumnsByTable($_POST);

}

/*------------------------------------------------
              getPrimaryColumnsByTable  
--------------------------------------------------*/
if (isset($_POST['act']) && $_POST['act'] === 'getPrimaryColumnsByTable') {

    $engine->getPrimaryColumnsByTable($_POST);

}

/*------------------------------------------------
					generate  
--------------------------------------------------*/
if (isset($_POST['act']) && $_POST['act'] === 'generate') {

    $engine->generate($_POST);

}

?>