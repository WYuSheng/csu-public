<?php

namespace Gini\Controller\CGI;

class Member extends Layout\Home {
    function __index() {
        $this->redirect('member/list');
    }

    public function actionList() {
    	$form = $this->form('post');
        $links = those('link')->whose('type')->is(\Gini\ORM\Link::TYPE_MEMBER);

        if (isset($form['member_name'])) {
        	$links = $links->whose('name')->contains($form['member_name']);
        }
        $this->view->body->content = V('member/list', [
            'links' => $links
        ]);
    }
}