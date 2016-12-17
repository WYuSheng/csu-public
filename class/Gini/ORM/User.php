<?php

namespace Gini\ORM;

class User extends Object
{
    public $name        = 'string:50';
    public $nickname    = 'string:120';
    public $readonly    = 'int';
    public $ctime       = 'datetime';

    protected static $db_index = [
        'unique:name',
        'nickname',
        'ctime',
    ];

    public function save()
    {
        if ($this->ctime == '0000-00-00 00:00:00' || !$this->ctime) {
            $this->ctime = date('Y-m-d H:i:s');
        }
        return parent::save();
    }

}