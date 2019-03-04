<?php

spl_autoload_register(function($classname) {
  // var_dump($classname[0]);
  if ($classname[0] == 'C') include_once("c/$classname.php");
  else include_once("m/$classname.php");
});

session_start();


$action = 'action_';
$action .= (isset($_GET['act'])) ? $_GET['act'] : 'index';

switch ($_GET['c'])
{
	case 'articles':
		$controller = new C_Page();
		break;
  case 'auth':
    $controller = new C_Auth();
    break;
	default:
		$controller = new C_Page();
}

$controller->Request($action);
