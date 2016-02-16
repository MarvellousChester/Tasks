<?php
namespace Cgi\Trainee;

use Cgi\Orm\EntityAbstract;

class Category extends EntityAbstract
{
    protected function getTableName()
    {
        return 'category';
    }

    protected function beforeSave()
    {
        if(!$this->isLoaded) {
            //Если url_key отсутствует, то формируем его на основе name
            if(empty($this->data['url_key'])) {
                $this->data['url_key'] = $this->data['name'];
            }
            //Приводим url_key в нужный формат
            $this->data['url_key']
                = mb_strtolower(strtr(trim($this->data['url_key']), ' ', '-'));
        }
    }
}