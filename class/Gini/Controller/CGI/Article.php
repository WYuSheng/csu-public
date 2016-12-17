<?php

namespace Gini\Controller\CGI;

class Article extends Layout\Home {

    function __index() {
        $this->redirect('article/list');
    }

    function actionList($type = 0) {
        if (!array_key_exists($type, \Gini\ORM\Article::$TYPE)) {
            $this->redirect('error/404');
        }

        if ($type == \Gini\ORM\Article::TYPE_QUES) {
            $this->redirect('question/list');
        } 
        elseif ($type == \Gini\ORM\Article::TYPE_RULE) {
            $this->redirect('rule/list');
        }

        $articles = those('article')->whose('type')->is($type)->orderBy('ctime','desc');

        $this->view->body->content = V('article/list', [
            'type' => $type,
            'articles' => $articles
        ]);
    }
    
    function actionContent($id = 0) {
        $article = a('article', $id);
        if (!$article->id) {
            $this->redirect('error/404');
        }

        $type = $article->type;
        switch ($type) {
            case \Gini\ORM\Article::TYPE_QUES:
                $this->redirect('question/content/' . $id);
                break;
            case \Gini\ORM\Article::TYPE_RULE:
                $this->redirect('rule/content/' . $id);
                break;
            default:
                break;
        }

         $this->view->body->content = V('article/content', [
            'article' => $article
        ]);
    }
}
