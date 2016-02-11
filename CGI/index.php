<?php
namespace CGI;

require_once ('Model/User.php');
require_once ('Model/Category.php');

use CGI\Trainee\User;
use CGI\Trainee\Category;

echo 'Hello! <br />';

$user = new User(['first_name' => 'John', 'last_name' => 'Stone', 'email' => 'JohnStone@mail.ru']);
$user->set('first_name', 'Alex');
$user->save();
$user2 = new User();
$user2->set('first_name', 'Bob');
$user2->set('last_name', 'Kerman');
$user2->set('email', 'KSP@kerbal.com');
$user2->save();


$category2 = new Category(['name' => 'category2', 'url_key' => 'sfSfsf  sFsfsf']);
$category2->save();
