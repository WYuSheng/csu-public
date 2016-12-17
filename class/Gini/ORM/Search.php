<?php

namespace Gini\ORM;

class Search extends Object
{
    public $name        = 'string:50';
    public $count       = 'int,default:0';

    protected static $db_index = [
        'count'
    ];

    function increase() {
        $this->count += 1;
        return parent::save();
    }

}
