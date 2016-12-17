<?php

namespace Gini\Controller\CGI\Layout;

abstract class Layout extends \Gini\Controller\CGI\Layout {

    function __postAction($action, &$params, $response) {

        return parent::__postAction($action, $params, $response);
    }
}

