<?php

/*
 * -------------------------------------
 * Database.php
 * -------------------------------------
 */

class Database extends PDO
{
	public $_paginacion = array();


public function __construct() {
try
	{
    	$dsn =  DB_ENGINE .':host='. DB_HOST .';dbname='.DB_NAME;
        parent::__construct($dsn,DB_USER,DB_PASS,
                array(
				 PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));

/* $dsn =  DB_ENGINE .':host='. DB_HOST .';dbname='.DB_NAME;
        parent::__construct($dsn,DB_USER,DB_PASS,
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . UTF8));	 */				
    }
catch (PDOException $e) {
		$dbh=null;
		echo "Error de conexion con  la bd".$e->getCode();
}	


}
}
?>
