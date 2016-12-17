<?php
namespace Gini\Controller\CGI\AJAX;

class Image extends \Gini\Controller\CGI {

    public function actionAdd () {
        $view = V('image/add');
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }

    public function actionDelete($id) {
        $image = a('image', $id);
        if (!$image->id) {
            \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            $view = V('redirect', []);
            return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
        }

        $form = $this->form('post');

        if ($form) {
            if (!$image->delete()) {
                \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            }
            else {
                \Gini\Module\Help::message(T('操作成功'), 'success');
            }
            $view = V('redirect', ['url' => '/admin/image']);
            return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
        }
        $view = V('image/delete', [
            'image' => $image
        ]);
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }

}
