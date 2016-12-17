<?php
namespace Gini\Controller\CGI\AJAX;

class Download extends \Gini\Controller\CGI {

    public function actionAdd () {
        $view = V('download/add');
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }

    public function actionDelete($id) {
        $download = a('download', $id);
        if (!$download->id) {
            \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            $view = V('redirect', []);
            return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
        }

        $form = $this->form('post');

        if ($form) {
            if (!$download->delete()) {
                \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            }
            else {
                \Gini\Module\Help::message(T('操作成功'), 'success');
            }
            $view = V('redirect', ['url' => '/admin/download']);
            return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
        }
        $view = V('download/delete', [
            'download' => $download
        ]);
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }
}
