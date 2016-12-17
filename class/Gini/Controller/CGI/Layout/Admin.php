<?php

namespace Gini\Controller\CGI\Layout;

class Admin extends Layout {

    function __preAction($action, &$params) {
        $me = _G('ME');

        if (!$me->id) {
            $this->redirect('login');
        }
        
        $this->view = V('layout');

        $this->view->head = V('admin/head');
        $this->view->body = V('admin/body');
        
        $this->view->footer = V('admin/footer');
        
    }

}
