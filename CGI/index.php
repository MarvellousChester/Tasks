<?php
use CGI\Autoloader;

require_once('Autoloader.php');

$autoloader = new Autoloader();
$autoloader->register();

use CGI\Trainee\User;
use CGI\Trainee\Category;

echo 'Hello! <br />';

//$user = new User(['first_name' => 'John', 'last_name' => 'Stone', 'email' => 'JohnStone@mail.ru']);
//$user->set('first_name', 'Alex');
//$user->save();
//$user2 = new User();
//$user2->set('first_name', 'Bob');
//$user2->set('last_name', 'Kerman');
//$user2->set('email', 'KSP@kerbal.com');
////$user2->save();
//$user3 = new User();
//$user3->load(4);
//$user3->set('first_name', 'sfsfsgfsf');
//$user3->save();
//var_dump($user3->get('first_name'));



$category2 = new Category(['name' => 'category2', 'url_key' => 'sfSfsf  sFsfsf']);
$category2->save();
$category = new Category();
$category->load(2);
$category->set('name', 'New Category');
$category->save();
