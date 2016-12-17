<?php

namespace Gini\ORM;

class Article extends Object
{
    public $title       = 'string:50';
    public $content     = 'string:*';
    public $type        = 'int,default:0';
    public $description = 'string:*';
    public $author      = 'object:user';
    public $ctime       = 'datetime';

    protected static $db_index = [
        'type', 'author',
        'title','ctime',
    ];

    const TYPE_SCHOOL = 0;
    const TYPE_LAB = 1;
    const TYPE_QUES = 2;
    const TYPE_RULE = 3;

    public static $TYPE = [
        self::TYPE_SCHOOL => '学校通知',
        self::TYPE_LAB => '实验室动态',
        self::TYPE_QUES => '常见问题',
        self::TYPE_RULE => '规章制度',
    ];

    function save() {
        if (!$this->ctime || $this->ctime == '0000-00-00 00:00:00') $this->ctime = date('Y-m-d H:i:s');
        return parent::save();
    }

}
