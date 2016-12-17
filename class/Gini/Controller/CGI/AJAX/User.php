<?php
namespace Gini\Controller\CGI\AJAX;

class User extends \Gini\Controller\CGI {

    public function actionAdd () {
        $form = $this->form('post');

        if ($form) {
            $validator = new \Gini\CGI\Validator;
            try {
                $validator
                    ->validate('nickname', !!$form['nickname'], T('姓名不能为空!'))
                    ->validate('name', !!$form['name'], T('账号不能为空!'))
                    ->validate('password', !!$form['password'], T('密码不能为空!'))
                    ->validate('confirm', !!$form['confirm'], T('确认密码不能为空!'))
                    ->validate('confirm', $form['confirm'] === $form['password'], T('两次密码不一致!'));

                $user = a('user')->whose('name')->is($form['name']);
                if ($user->id) {
                    $validator->validate('name', false, T('该用户已存在!'));
                }
                
                $validator->done();

                $user->name = $form['name'];
                $user->nickname = $form['nickname'];

                if ($user->save()) {
                    $auth = \Gini\IoC::construct('\Gini\Auth', $user->name);
                    if (!$auth->create($form['password'])) {
                        $user->delete();
                        \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
                    }
                    else {
                        \Gini\Module\Help::message(T('操作成功'), 'success');
                    }
                }
                else {
                    \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
                }
                $view = V('redirect', ['url' => '/admin/user']);
                return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
            }
            catch (\Gini\CGI\Validator\Exception $e) {
                $form['_errors'] = $validator->errors();
            }
        }

        $view = V('user/add', [
            'form' => $form
        ]);
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }

    public function actionEdit($id = 0) {
        $user = a('user', $id);
        if (!$user->id) {
            \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            $view = V('redirect');
            return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
        }

        $form = $this->form('post');

        if ($form) {
            $validator = new \Gini\CGI\Validator;
            try {
                $validator
                    ->validate('nickname', !!$form['nickname'], T('姓名不能为空!'))
                    ->validate('name', !!$form['name'], T('账号不能为空!'));
                    
                if (!empty($form['password']) || !empty($form['confirm'])){
                    $validator->validate('confirm', $form['confirm'] === $form['password'], T('两次密码不一致!'));
                }

                $otherUser = a('user')->whose('name')->is($form['name']);
                if ($otherUser->id && $otherUser->id != $user->id) {
                    $validator->validate('name', false, T('该用户已存在!'));
                }
                
                $validator->done();

                if ($user->name != $form['name']) {
                    $auth = new \Gini\Auth($user->name);
                    $auth->changeUserName($form['name']);
                }

                $user->name = $form['name'];
                $user->nickname = $form['nickname'];

                if ($user->save()) {
                    $auth = \Gini\IoC::construct('\Gini\Auth', $user->name);
                    if (!empty($form['password']) && !$auth->changePassword($form['password'])) {
                        \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
                    }
                    else {
                        \Gini\Module\Help::message(T('操作成功'), 'success');
                    }
                }
                else {
                    \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
                }
                $view = V('redirect', ['url' => '/admin/user']);
                return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
            }
            catch (\Gini\CGI\Validator\Exception $e) {
                $form['_errors'] = $validator->errors();
            }
        }

        $view = V('user/edit', [
            'form' => $form,
            'user' => $user
        ]);
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }

    public function actionDelete($id = 0) {
        $user = a('user', $id);
        if (!$user->id) {
            \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            $view = V('redirect', []);
            return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
        }

        $form = $this->form('post');

        if ($form) {
            $auth = new \Gini\Auth($user->name);
            if (!$user->delete() || !$auth->remove()) {
                \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            }
            else {
                \Gini\Module\Help::message(T('操作成功'), 'success');
            }
            $view = V('redirect', ['url' => '/admin/user']);
            return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
        }
        $view = V('user/delete', [
            'user' => $user
        ]);
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }

}
