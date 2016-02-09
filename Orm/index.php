<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 09.02.16
 * Time: 13:55
 */
require_once 'User.php';
require_once 'Category.php';

echo 'Hello! <br />';
$user = new User();
$user->load('1');
echo $user->get('first_name') . '<br />';
echo $user->get('last_name') . '<br />';
echo $user->get('email') . '<br />';
echo $user->get('creation_date') . '<br />';

$user->set('first_name', 'Alex');
$user->save();
echo $user->get('first_name') . '<br />';

$user2 = new User('John','Thornton', 'test@test.com');
echo $user2->get('first_name') . '<br />';
echo $user2->get('last_name') . '<br />';
echo $user2->get('email') . '<br />';
echo $user2->get('creation_date') . '<br />';
#$user2->save();

$user3 = new User();
$user3->set('first_name', 'Pite');
$user3->set('last_name', 'Stown');
$user3->set('email', '1234@mail.ru');

echo $user3->get('first_name') . '<br />';
echo $user3->get('last_name') . '<br />';
echo $user3->get('email') . '<br />';
echo $user3->get('creation_date') . '<br />';
$user3->save();


$category = new Category('first', 'key');
echo $category->get('name'). '<br />';
#$category->save();
$category2 = new Category();
$category2->load('2');
echo $category->get('name'). '<br />';
echo $category->get('url_key'). '<br />';
$category2->set('name', 'second1 4555 434343 ');
$category2->set('url_key', 'key 21 456 erttee');
$category2->save();
echo $category->get('name'). '<br />';
echo $category->get('url_key'). '<br />';
$category3 = new Category();
$category3->load(3);
#$category3->delete();
$category4 = new Category('My very First Category ');
$category4->save();