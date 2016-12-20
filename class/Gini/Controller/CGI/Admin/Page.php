<?php

namespace Gini\Controller\CGI\Admin;

class Page extends \Gini\Controller\CGI\Layout\Admin {

    function __index($type = 0) {
        if (!array_key_exists($type, \Gini\ORM\Article::$PAGE_TYPE)) {
            $this->redirect('error/404');
        }
        
        $form = $this->form('post');

        $article = a('article')->whose('type')->is($type);
        if (!$article->id) {
            $article = a('article');
            $article->title = \Gini\ORM\Article::$PAGE_TYPE[$type];
            $article->type = $type;
            $article->save();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new \Gini\CGI\Validator;
            try {
                $article->content = $form['content'];

                if($article->save()) {
                    \Gini\Module\Help::message(T('操作成功'), 'success');
                }
            }
            catch (\Gini\CGI\Validator\Exception $e) {
                $form['_errors'] = $validator->errors();
                \Gini\Module\Help::message(T(current($form['_errors'])), 'danger');
            }
        }

        $this->view->body->content = V('article/admin_page', [
            'article' => $article,
        ]);
    }
}
