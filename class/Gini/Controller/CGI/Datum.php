<?php

namespace Gini\Controller\CGI;

class Datum extends Layout\Home {

    function __index() {
        $this->redirect('datum/list');
    }

    function actionList() {
        $downloads = those('download')->orderBy('ctime','desc');
        $this->view->body->content = V('download/list', [
            'downloads' => $downloads
        ]);
    }

}