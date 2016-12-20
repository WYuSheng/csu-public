<?php

namespace Gini\ORM;

class Link extends Object
{
    public $name        = 'string:50';
    public $href        = 'string:*';
    public $type        = 'int,default:0';
    public $ctime       = 'datetime';

    protected static $db_index = [
        'name', 'ctime',
    ];

    const TYPE_LINK = 0;
    // const TYPE_MEMBER = 1;

    public static $TYPE = [
        self::TYPE_LINK => '友情链接',
        // self::TYPE_MEMBER => '平台成员',
    ];

    function save() {
        if (!$this->ctime || $this->ctime == '0000-00-00 00:00:00') $this->ctime = date('Y-m-d H:i:s');
        return parent::save();
    }

}
