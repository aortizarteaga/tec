<?php

/*
 * -------------------------------------
 *  Config.php
 * -------------------------------------
 */

define('TIMEOUT',5);
//define('BASE_URL', 'http://'.$_SERVER['SERVER_NAME'].'/aseguram/tec/');
define('BASE_URL', 'http://'.$_SERVER['SERVER_NAME'].':800/tec/');
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_LAYOUT', 'default');
date_default_timezone_set('America/Lima');

//CONEXION MYSQL GLOBAL CARD
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '12345678');
define('DB_NAME', 'desarollo-ase');

define('DB_ENGINE','mysql');

?>

