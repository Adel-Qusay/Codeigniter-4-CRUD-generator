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

error_reporting(E_ALL);
ini_set('display_errors', 0);

/*
|--------------------------------------------------------------------------
| Define dirs
|--------------------------------------------------------------------------
|
*/
define('ABSPATH', 	dirname( __FILE__ ) . '/');
define('CORE',  	ABSPATH . 'core');
define('VIEWS',    	ABSPATH . 'views');
define('MVC_TPL',   ABSPATH . 'mvc_templates');
define('DOWNLOADS', ABSPATH . 'downloads');
define('ASSETS',   	'../assets');
define('BASE_URL',  (isset($_SERVER['HTTPS']) ? 'http' : 'http') . '://'.$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));

/*
|--------------------------------------------------------------------------
| Database configurations
|--------------------------------------------------------------------------
|
*/

$config['HOST'] = '127.0.0.1';
$config['USER'] = 'root';
$config['PASS'] = 'root';

/*
|--------------------------------------------------------------------------
| Include files required for initialization.
|--------------------------------------------------------------------------
|
*/
include_once CORE . '/viewloader.class.php';
include_once CORE . '/class.engine.php';

// Load core files
$engine = new Engine($config);
$viewLoader = new ViewLoader(VIEWS .'/');

?>
