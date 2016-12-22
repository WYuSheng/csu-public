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

    const TYPE_INSTRU = 0;
    const TYPE_CONNEC = 1;
    const TYPE_COMMU = 2;
    const TYPE_NOTIC = 3;
    const TYPE_SERVI = 4;
    const TYPE_RULES = 5;
    const TYPE_QUEST = 6;
    const TYPE_GUIDE = 7;

    public static $PAGE_TYPE = [
        self::TYPE_INSTRU => '平台介绍',
        self::TYPE_CONNEC => '联系我们',
    ];
    public static $TYPE = [
        self::TYPE_COMMU => '培训交流',
        self::TYPE_NOTIC => '通知公告',
        self::TYPE_SERVI => '服务流程',
        self::TYPE_RULES => '规章制度',
        self::TYPE_QUEST => '问题解答',
        self::TYPE_GUIDE => '服务指南'
    ];

    function save() {
        if (!$this->ctime || $this->ctime == '0000-00-00 00:00:00') $this->ctime = date('Y-m-d H:i:s');
        return parent::save();
    }

}
