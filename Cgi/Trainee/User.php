<?php
namespace Cgi\Trainee;

use Cgi\Orm\EntityAbstract;

class User extends EntityAbstract
{
    protected function getTableName()
    {
        return 'user';
    }

    protected function beforeSave()
    {
        if (!$this->isLoaded) {
            $this->data['creation_date'] = date('Y-m-d H:i:s');
        }
    }
}