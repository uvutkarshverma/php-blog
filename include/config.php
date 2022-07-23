<?php

function autoload($class){
    $class= strtolower($class);

    $classpath = '/classes/class.'.$class . '.php';
    if (file_exists($classpath)) {
        require_once $classpath;
    }
    $classpath = '../classes/class.'.$class . '.php';
    if (file_exists($classpath)) {
        require_once $classpath;
    }
    $classpath = '../../classes/class.'.$class . '.php';
    if (file_exists($classpath)) {
        require_once $classpath;
    }
    $classpath = 'classes/class.'.$class . '.php';
    if (file_exists($classpath)) {
        require_once $classpath;
    }
    $classpath = '../blog/classes/class.'.$class . '.php';
    if (file_exists($classpath)) {
        require_once $classpath;
    }
}
spl_autoload_register('autoload');

ob_start();
session_start();
define('DBHOST','localhost');
define('DBUSER','qnastopc');
define('DBPASS','');
define('DBNAME','qnastopc_qnastop');


$db=new PDO("mysql:host=".DBHOST.";dbname=".DBNAME,DBUSER,DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


date_default_timezone_set("asia/kolkata");



$user=new User($db);


include("function.php");
?>


