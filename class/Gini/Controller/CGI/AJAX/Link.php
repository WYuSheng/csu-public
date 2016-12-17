<?php
namespace Gini\Controller\CGI\AJAX;

class Link extends \Gini\Controller\CGI {

    public function actionAdd () {
        $form = $this->form('post');

        if ($form) {
            $validator = new \Gini\CGI\Validator;
            try {
                $validator
                    ->validate('name', !!$form['name'], T('名称不能为空!'))
                    ->validate('href', !!$form['href'], T('地址不能为空!'));

                $validator->done();
                
                $link = a('link');
                $link->name = $form['name'];
                $link->type = $form['type'];
                $link->href = $form['href'];

                if ($link->save()) {
                    \Gini\Module\Help::message(T('操作成功'), 'success');
                }
                else {
                    \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
                }
                $view = V('redirect', ['url' => 'admin/link']);
                return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
            }
            catch (\Gini\CGI\Validator\Exception $e) {
                $form['_errors'] = $validator->errors();
            }
        }

        $view = V('link/add', [
            'form' => $form
        ]);
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }

    public function actionEdit($id) {
        $link = a('link', $id);
        if (!$link->id) {
            \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            $view = V('redirect', []);
            return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
        }

        $form = $this->form('post');

        if ($form) {
            $validator = new \Gini\CGI\Validator;
            try {
                $validator
                    ->validate('name', !!$form['name'], T('名称不能为空!'))
                    ->validate('href', !!$form['href'], T('地址不能为空!'));

                $validator->done();
                
                $link->name = $form['name'];
                $link->type = $form['type'];
                $link->href = $form['href'];

                if ($link->save()) {
                    \Gini\Module\Help::message(T('操作成功'), 'success');
                }
                else {
                    \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
                }
                $view = V('redirect', ['url' => 'admin/link']);
                return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
            }
            catch (\Gini\CGI\Validator\Exception $e) {
                $form['_errors'] = $validator->errors();
            }
        }

        $view = V('link/edit', [
            'form' => $form,
            'link' => $link
        ]);
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }

    public function actionDelete($id = 0) 
    {
        $link = a('link', $id);
        if (!$link->id) {
            \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            $view = V('redirect', []);
            return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
        }

        $form = $this->form('post');

        if ($form) {
            if (!$link->delete()) {
                \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            }
            else {
                \Gini\Module\Help::message(T('操作成功'), 'success');
            }
            $view = V('redirect', ['url' => '/admin/link']);
            return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
        }
        $view = V('link/delete', [
            'link' => $link
        ]);
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }
}
