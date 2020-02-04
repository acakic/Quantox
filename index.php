<?php 
session_start();

define("WEBROOT", "http://www.quantoxtest.com/");

foreach (glob('./classes/*') as $class_name) {
	require_once($class_name);                     
}
foreach (glob('./model/*') as $model_name) {
	require_once($model_name);
}
foreach (glob('./controller/*') as $controller_name) {
	require_once($controller_name);
}
// instansiate db class
require_once('./Database.php');
$database = new Database();
// connecting with db;
$conn = $database->connect();

$request = new Request();
$router = new Router($request);
