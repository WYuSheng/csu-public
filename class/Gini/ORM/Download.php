<?php

namespace Gini\ORM;

class Download extends Object
{
    public $title           = 'string:100';
    public $fullPath        = 'string:500';
    public $fileName        = 'string:100';
    public $fileExtension   = 'string:50';
    public $ctime           = 'datetime';

    protected static $db_index = [
        'title', 'fullPath',
        'fileName', 'fileExtension',
        'ctime',
    ];

    public function src() {
        return H($this->fullPath . '/' . $this->fileName);
    }

    public function save()
    {
        if ($this->ctime == '0000-00-00 00:00:00' || !$this->ctime) {
            $this->ctime = date('Y-m-d H:i:s');
        }
        return parent::save();
    }

}