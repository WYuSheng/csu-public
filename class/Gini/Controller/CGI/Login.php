<?php

namespace Gini\Controller\CGI;

class Login extends Layout\Login {

    function __index() {
        $me = _G('ME');
        if (\Gini\Auth::isLoggedIn() && $me->id) {
            $this->redirect('admin/user');
        }
        
        $form = $this->form('post');

        if ($form) {
            $validator = new \Gini\CGI\Validator;
            try {
                $validator
                    ->validate('name', !!$form['name'], T('账号不能为空!'))
                    ->validate('password', !!$form['password'], T('密码不能为空!'));

                $auth = \Gini\IoC::construct('\Gini\Auth', $form['name']);

                if ($auth->verify($form['password'])) {
                    \Gini\Auth::login($form['name']);
                    $this->redirect('admin');
                }
                else {
                    $validator->validate('name', false, T('用户名或密码错误'));
                }
                
                $validator->done();
            }
            catch (\Gini\CGI\Validator\Exception $e) {
                $form['_errors'] = $validator->errors();
            }
        }

        $this->view->body->content = V('login/content', [
            'form' => $form
        ]);
    }

}
