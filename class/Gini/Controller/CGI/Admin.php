<?php

namespace Gini\Controller\CGI;

class Admin extends Layout\Admin {

    function __index() {
        $this->redirect('admin/user');
    }

}
