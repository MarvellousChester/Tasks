<?php

require_once 'User.php';
require_once 'Category.php';
require_once 'PdoConnection.php';

echo 'Hello! <br />';
$connection = new PdoConnection('file');
$pdo = $connection->establish();

$user = new User($pdo, ['fist_name' => 'John', 'last_name' => 'Stone', 'email' => 'JohnStone@mail.ru']);
$user->set('first_name', 'Alex');
$user->save();


$category2 = new Category($pdo, ['name' => 'category', 'url_key' => 'sfsfsf-sfsfsf']);
$category2->save();
