<?php

namespace Gini\Controller\CGI\Admin;

class Download extends \Gini\Controller\CGI\Layout\Admin {

    function __index($id = 0) {
        
        $downloads = those('download');
        $this->view->body->content = V('download/admin', [
            'downloads' => $downloads
        ]);
    }

    function actionAdd() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $form = $this->form('post');

            $validator = new \Gini\CGI\Validator;
            try {
                $validator
                    ->validate('title', !!$form['title'], T('标题不能为空!'));
                $validator->done();

                $path = DATA_DIR . '/downloads';
                \Gini\File::ensureDir($path);
                $file = $this->form('files')['file'];
                \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
                if (is_dir($path) && is_uploaded_file($file['tmp_name'])
                && move_uploaded_file($file['tmp_name'], $path . '/' . $file['name'])) {
                    $download = a('download');
                    $download->title = $form['title'];
                    $download->fullPath = $path;
                    $download->fileName = $file['name'];
                    $download->fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $download->save();
                    \Gini\Module\Help::message(T('操作成功'), 'success');
                }
            }
            catch (\Gini\CGI\Validator\Exception $e) {
                $form['_errors'] = $validator->errors();
                \Gini\Module\Help::message(T(current($form['_errors'])), 'danger');
            }
        }
        
        $this->redirect('admin/download');
    }
}
