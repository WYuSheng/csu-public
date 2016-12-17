<?php

namespace Gini\Module {

    class CsuPublic {

        static function setup() {

            date_default_timezone_set(\Gini\Config::get('system.timezone') ?: 'Asia/Shanghai');

            class_exists('\Gini\Those');

            setlocale(LC_MONETARY, \Gini\Config::get('system.locale') ?: 'zh_CN');
            
            \Gini\I18N::setup();

            $username = \Gini\Auth::userName();
            $user = a('user')->whose('name')->is($username);
            
            if ($user->id) {
                _G('ME', $user);
            }
        }

        static function shutdown() {

        }

    }

}

