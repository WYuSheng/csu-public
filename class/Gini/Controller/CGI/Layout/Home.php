<?php

namespace Gini\Controller\CGI\Layout;

class Home extends Layout {

    function __preAction($action, &$params) {

        $route = \Gini\CGI::route();
        if ($route) $route = explode('/', $route);
        if (!$route || count($route) == 0) {
            $route = 'index';
        }
        else {
            $route = $route[0];
        }
        $links = those('link')->whose('type')->is(\Gini\ORM\Link::TYPE_LINK)->limit(5);
        
        $this->view = V('layout');

        $this->view->head = V('home/head');
        $this->view->body = V('home/body', [
                'route' => $route,
                'links' => $links
            ]);
        
        $this->view->footer = V('home/foot');
        
    }

}

