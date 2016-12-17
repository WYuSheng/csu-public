<?php

namespace Gini\Controller\CGI\Admin;

class User extends \Gini\Controller\CGI\Layout\Admin {

    function __index() {

        $form = $this->form('post');
        $users = those('user');

        if ($form['keyword']) {
            $users = $users->whose('nickname')->contains($form['keyword']);
        }
        
        $this->view->body->content = V('user/admin', [
            'users' => $users
        ]);
    }
}
