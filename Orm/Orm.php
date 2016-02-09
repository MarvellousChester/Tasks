<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 09.02.16
 * Time: 12:37
 */
include 'OrmInterface.php';

abstract class OrmAbstract implements Orm_OrmInterface
{
    public function set($field, $value)
    {

    }
    public function get($field)
    {
        // TODO: Implement get() method.
    }
    public function load($id)
    {
        // TODO: Implement load() method.
    }
    public function save()
    {
        // TODO: Implement save() method.
    }
    public function delete()
    {
        // TODO: Implement delete() method.
    }
    
}