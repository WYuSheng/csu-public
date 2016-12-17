<?php
namespace Gini\Controller\CGI\AJAX;

class Article extends \Gini\Controller\CGI {

    public function actionAdd () {
        $types = \Gini\ORM\Article::$TYPE;
        $view = V('article/add', [
            'types' => $types,
        ]);
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }

    public function actionEdit($id) {
        $article = a('article', $id);
        if (!$article->id) {
            \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            $view = V('redirect', []);
            return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
        }
        $types = \Gini\ORM\Article::$TYPE;
        $view = V('article/edit', [
            'types' => $types,
            'article' => $article
        ]);
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }

    public function actionDelete($id) {
        $article = a('article', $id);
        if (!$article->id) {
            \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            $view = V('redirect', []);
            return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
        }

        $form = $this->form('post');

        if ($form) {
            if (!$article->delete()) {
                \Gini\Module\Help::message(T('操作失败, 请联系管理员'), 'danger');
            }
            else {
                \Gini\Module\Help::message(T('操作成功'), 'success');
            }
            $view = V('redirect', ['url' => '/admin/article']);
            return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
        }
        $view = V('article/delete', [
            'article' => $article
        ]);
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }

    public function actionIndex($type = \Gini\ORM\Article::TYPE_SCHOOL) {
        $articles = those('article')->whose('type')->is($type)->limit(3)->orderBy('ctime','desc');
        $view = V('home/article_content', [
            'articles' => $articles
        ]);
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }
}
