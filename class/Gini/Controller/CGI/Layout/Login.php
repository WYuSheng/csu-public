<?php

namespace Gini\Controller\CGI\Layout;

class Login extends Layout {

    function __preAction($action, &$params) {
        
        $this->view = V('layout');

        $this->view->head = V('home/head');
        $this->view->body = V('login/body');
        
        $this->view->footer = V('login/footer');
        
    }

}
