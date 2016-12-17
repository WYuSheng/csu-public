<?php

namespace Gini\Controller\CGI\Admin;

class Image extends \Gini\Controller\CGI\Layout\Admin {

    function __index($id = 0) {
        
        $images = those('image');
        $this->view->body->content = V('image/admin', [
            'images' => $images
        ]);
    }

    function actionAdd() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $form = $this->form('post');

            $path = DATA_DIR . '/slides';
            \Gini\File::ensureDir($path);
            $file = $this->form('files')['file'];
            \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            if (is_dir($path) && is_uploaded_file($file['tmp_name'])
            && move_uploaded_file($file['tmp_name'], $path . '/' . $file['name'])) {
                $image = a('image');
                $image->title = $form['title'];
                $image->type = $form['type'];
                $image->fullPath = $path;
                $image->fileName = $file['name'];
                $image->fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $image->save();
                \Gini\Module\Help::message(T('操作成功'), 'success');
            }
        }
        
        $this->redirect('admin/image');
    }
}
