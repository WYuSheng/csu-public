<?php

namespace Gini\Module {

    class Help {

        static function message($content = '', $type = 'info') {
            $_SESSION['message'] = [
                'type' => $type,
                'content' => $content
            ];
        }

    }

}

