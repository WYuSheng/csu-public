<?php

namespace Gini\Controller\CGI\Admin;

class Link extends \Gini\Controller\CGI\Layout\Admin {

    function __index($type = '') {
        if (!array_key_exists($type, \Gini\ORM\Link::$TYPE) && $type !== '') {
            $this->redirect('error/404');
        }

        $form = $this->form('post');
        $links = those('link');
        if ($form['keyword']) {
            $links = $links->whose('name')->contains($form['keyword']);
        }

        if ($type !== ''){
            $links = $links->whose('type')->is($type);
        }
        
        $this->view->body->content = V('link/admin', [
            'links' => $links
        ]);
    }

}

