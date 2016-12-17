<?php

namespace Gini\Controller\CGI;

class Rule extends Layout\Home {

    function __index() {
        $this->redirect('question/list');
    }

    function actionList() {
        $type = \Gini\ORM\Article::TYPE_RULE;
        $articles = those('article')->whose('type')->is($type)->orderBy('ctime','desc');

        $this->view->body->content = V('article/list2', [
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
            case \Gini\ORM\Article::TYPE_SCHOOL:
            case \Gini\ORM\Article::TYPE_LAB:
                $this->redirect('article/content/' . $id);
                break;
            case \Gini\ORM\Article::TYPE_QUES:
                $this->redirect('question/content/' . $id);
                break;
            default:
                break;
        }

        $this->view->body->content = V('article/content2', [
            'type' => $type,
            'article' => $article
        ]);
    }
}
