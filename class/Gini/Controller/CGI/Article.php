<?php

namespace Gini\Controller\CGI;

class Article extends Layout\Home {

    function __index() {
        $this->redirect('article/list');
    }

    function actionList($type = 1) {
        if (array_key_exists($type, \Gini\ORM\Article::$TYPE)) {
            $view = 'list';
            $articles = those('article')->whose('type')->is($type)->orderBy('ctime','desc');
        }
        elseif (array_key_exists($type, \Gini\ORM\Article::$PAGE_TYPE)) {
            $view = 'list2';
            $articles = a('article')->whose('type')->is($type);
        }
        else {
            $this->redirect('error/404');
        }


        $this->view->body->content = V('article/'.$view, [
            'type' => $type,
            'articles' => $articles
        ]);
    }
    
    function actionContent($id = 0) {
        $article = a('article', $id);
        if (!$article->id) {
            $this->redirect('error/404');
        }

         $this->view->body->content = V('article/content', [
            'article' => $article
        ]);
    }
}
