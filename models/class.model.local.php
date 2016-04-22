<?php
error_reporting(E_ERROR);
require "class.model.session.php";
define('sysNow',date('Y-m-d H:i:s'));
define('sysVisitorIP',$_SERVER['REMOTE_ADDR']);
//Connection To MYSQL DataBase
define('secretKey','gwdf34jw4fs43jf943f438ampqlnfgeshgfdfdshf3e3012');


class db{

/*** Declare instance ***/
private static $instance = NULL;

/**
	table names
**/

	
	public $table_3 = "cvs";

	
/**
*
* the constructor is set to private so
* so nobody can create a new instance using new
*
*/
private function __construct() {
  /*** maybe set the db name here later ***/
}

/**
*
* Return DB instance or create intitial connection
*
* @return object (PDO)
*
* @access public
*
*/
public static function getInstance() {

if (!self::$instance)
    {
    self::$instance = new PDO("mysql:host='127.0.0.1';dbname='k0171514'", 'root', '');
    self::$instance-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
return self::$instance;
}

/**
*
* Like the constructor, we make __clone private
* so nobody can clone the instance
*
*/
private function __clone(){
}

} /*** end of class ***/

try    {
    /*** query the database ***/
    $result = DB::getInstance()->query("SELECT * FROM animals");

    /*** loop over the results ***/
    foreach($result as $row)
        {
        print $row['animal_type'] .' - '. $row['animal_name'] . '<br />';
        }
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }
?>
