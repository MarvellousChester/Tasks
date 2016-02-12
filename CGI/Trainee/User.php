<?php
namespace CGI\Trainee;

use CGI\Orm\EntityAbstract;

class User extends EntityAbstract
{
    public function getId()
    {
        if (array_key_exists('user_id', $this->data)) {
            return $this->data['user_id'];
        } else {
            return false;
        }
    }

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