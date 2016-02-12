<?php
namespace CGI\Trainee;

use CGI\Orm\EntityAbstract;

class Category extends EntityAbstract
{
    public function getId()
    {
        if(array_key_exists('category_id', $this->data))
            return $this->data['category_id'];
        else return false;
    }
    protected function getTableName()
    {
        return 'category';
    }

    protected function beforeSave()
    {
        if(!$this->isLoaded) {
            //Если url_key отсутствует, то формируем его на основе name
            if ($this->data['url_key'] == '') {
                $this->data['url_key'] = $this->data['name'];
            }
            //Приводим url_key в нужный формат
            $this->data['url_key']
                = mb_strtolower(strtr(trim($this->data['url_key']), ' ', '-'));
        }
    }
}