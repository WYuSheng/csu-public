<?php

namespace Gini\Controller\CGI\Admin;

class Article extends \Gini\Controller\CGI\Layout\Admin {

    function __index($type = '') {
        if (!array_key_exists($type, \Gini\ORM\Article::$TYPE) && $type !== '') {
            $this->redirect('error/404');
        }
        
        $form = $this->form('post');
        $articles = those('article')->whose('type')->isNot(\Gini\ORM\Article::TYPE_INSTRU)
            ->andWhose('type')->isNot(\Gini\ORM\Article::TYPE_CONNEC);;
        if ($form['keyword']) {
            $articles = $articles->whose('title')->contains($form['keyword']);
        }

        if ($type !== ''){
            $articles = $articles->whose('type')->is($type);
        }

        // $articles = $articles->orderBy('ctime', 'desc');
        $this->view->body->content = V('article/admin', [
            'articles' => $articles,
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

                $article = a('article');
                $article->title = $form['title'];
                $article->ctime = $form['ctime'];
                $article->content = $form['content'];
                $article->type = $form['type'];

                if($article->save()) {
                    \Gini\Module\Help::message(T('操作成功'), 'success');
                }
            }
            catch (\Gini\CGI\Validator\Exception $e) {
                $form['_errors'] = $validator->errors();
                \Gini\Module\Help::message(T(current($form['_errors'])), 'danger');
            }
        }
        
        $this->redirect('admin/article');
    }

    function actionEdit($id) {
        $article = a('article', $id);
        if (!$article->id) {
            $this->redirect('error/404');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $form = $this->form('post');

            $validator = new \Gini\CGI\Validator;
            try {
                $validator
                    ->validate('title', !!$form['title'], T('标题不能为空!'));
                $validator->done();

                $article->title = $form['title'];
                $article->ctime = $form['ctime'];
                $article->content = $form['content'];
                $article->type = $form['type'];

                if($article->save()) {
                    \Gini\Module\Help::message(T('操作成功'), 'success');
                }
            }
            catch (\Gini\CGI\Validator\Exception $e) {
                $form['_errors'] = $validator->errors();
                \Gini\Module\Help::message(T(current($form['_errors'])), 'danger');
            }
        }
        
        $this->redirect('admin/article');
    }


}
