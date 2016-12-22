<?php
namespace Gini\Controller\CGI\AJAX;

class Equipment extends \Gini\Controller\CGI {

    public function actionTags () {
        $tags = self::getTags();
        return \Gini\IoC::construct('\Gini\CGI\Response\JSON', json_encode($tags));
    }

    public function actionGroups () {
        $groups = self::getGroups();
        return \Gini\IoC::construct('\Gini\CGI\Response\JSON', json_encode($groups));
    }

    static function getTags() {
        $cache = \Gini\Cache::of('csu_public');
        $cacheKey = 'tags';
        $tags = $cache->get($cacheKey);
        if (empty($tags)) {
            $lims = \Gini\Config::get('lims');
            $rpc = \Gini\IoC::construct('\Gini\RPC', $lims['api']);

            $tags = $rpc->equipment->getEquipmentTags($criteria);
            
            foreach ($tags as $key => $tag) {
                $tagCnt = $rpc->equipment->searchEquipments(['cat' => $key]);
                $tags[$key][cnt] = $tagCnt['total'];
            }
            $cache->set($cacheKey, $tags, 1800);
        }
        return $tags;
    }

    static function getGroups() {
        $cache = \Gini\Cache::of('csu_public');
        $cacheKey = 'groups';
        $groups = $cache->get($cacheKey);
        if (empty($groups)) {
            $lims = \Gini\Config::get('lims');
            $rpc = \Gini\IoC::construct('\Gini\RPC', $lims['api']);

            $groups = $rpc->equipment->getEquipmentGroups($criteria);
            $groups = current($groups)['children'];
            $cache->set($cacheKey, $groups, 1800);
        }
        return $groups;
    }

    public function actionEquipments () {
        $groups = self::getGroups();
        $tags = self::getTags();

        $form = $this->form('post');
        $criteria = [];
        
        //如果searchtext存在，则优先搜索仪器分类，其次搜索group（组织机构），如果没有再按仪器名称搜索
        if ($searchtext = $form['searchtext']) {
            foreach ($tags as $key => $value) {
                if (strstr($value['name'], $searchtext)) {
                    $criteria['cat'] = $key;
                    break;
                }
            }

            if (empty($criteria['cat'])) {
                foreach ($groups as $key => $value) {
                    if (strstr($value['name'], $searchtext)) {
                        $criteria['group'] = $key;
                        break;
                    }
                    else {
                        foreach ($value['children'] as $k => $v) {
                            if (strstr($v, $searchtext)) {
                                $criteria['group'] = $k;
                                break;
                            }
                        }
                        if ($criteria['group']) break; //如果children中已找到相应group，外层break
                    }
                }
            }

            if (empty($criteria['group']) && empty($criteria['cat'])) {
                $criteria['searchtext'] = $form['searchtext'];
            }
        }

        $form['tag'] ? ($criteria['group'] = $form['tag']) : '';
        $start = $form['start'] ? : 0;
        $num = $form['num'] ? : 10;

        $lims = \Gini\Config::get('lims');
        $rpc = \Gini\IoC::construct('\Gini\RPC', $lims['api']);

        // error_log(print_r($criteria,true));
        $result = $rpc->equipment->searchEquipments($criteria);

        $eqs = [];
        if ($result['total']) {
            $eqs = $rpc->equipment->getEquipments($result['token'], $start, $num);
        }

        $view = V('equipment/equipment', [
            'equipments' => $eqs,
        ]);
            
        return \Gini\IoC::construct('\Gini\CGI\Response\HTML', $view);
    }

    public function actionEquipmentRank () {
        $start = $form['start'] ? : 0;
        $end = $form['end'] ? : time();
        $num = $form['num'] ? : 5;

        $cache = \Gini\Cache::of('csu_public');
        $cacheKey = 'eq_rank';
        $eqs = $cache->get($cacheKey);
        if (empty($eqs)) {
            $lims = \Gini\Config::get('lims');
            $rpc = \Gini\IoC::construct('\Gini\RPC', $lims['api']);

            $eqranks = $rpc->equipment->use_rank($num, $start, $end);
            $ids = [];
            foreach ($eqranks as $key => $value) {
                $ids[] = $value['id'];
            }
            $criteria['ids'] = $ids;
            $result = $rpc->equipment->searchEquipments($criteria);
            $eqs = $rpc->equipment->getEquipments($result['token'], $start, $num);
            foreach ($eqs as $key => $value) {
                $eqs[$key]['use'] = $eqranks[$key]['use'];
            }
            $cache->set($cacheKey, $eqs, 1800);
        }
            
        return \Gini\IoC::construct('\Gini\CGI\Response\JSON', json_encode($eqs));
    }

}