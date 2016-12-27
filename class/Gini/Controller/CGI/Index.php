<?php

namespace Gini\Controller\CGI;

class Index extends Layout\Home {

    function __index() {
        $pics = those('image');

        $searchLength = 16;
        $search_db = those('search')->orderBy('count', 'd')->limit($searchLength);
        $searchs = [];
		foreach ($search_db as $value) {
			$searchs[] = ['name' => $value->name, 'count' => $value->count];
		}
    	$searchs = array_pad($searchs, $searchLength, ['name' => '--', 'count' => 0]);

        $this->view->body->content = V('home/homepage', [
            'pics' => $pics,
            'searchs' => $searchs,
        ]);
    }

}
