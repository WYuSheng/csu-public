<?php

namespace Gini\Controller\CGI;

class Equipment extends Layout\Home {

    function __index($id = 0) {
        $form = $this->form('post');
        $criteria['ids'] = [$id];

        $lims = \Gini\Config::get('lims');
        $rpc = \Gini\IoC::construct('\Gini\RPC', $lims['api']);

        $result = $rpc->equipment->searchEquipments($criteria);
        
        $eq = [];
        if (!$result['total']) {
            $this->redirect('404');
        } 
        
        $eq = $rpc->equipment->getEquipment($result['token'], $start, $num);
        $this->view->body->content = V('equipment/detail', [
            'equipment' => $eq
        ]);
    }

    function actionList($tag = 0) {
        $form = $this->form('post');
        $searchtext = $form['search_text'];
        //记录查询关键词
        if ($searchtext) {
            $searchCount = a('search')->whose('name')->is($searchtext);
            if (!$searchCount->id) {
                $searchCount = a('search');
                $searchCount->name = $searchtext;
            }
            $searchCount->increase();
        }
        
        $this->view->body->content = V('equipment/list', [
            'tag' => $tag,
            'searchtext' => $searchtext,
        ]);
    }

}
