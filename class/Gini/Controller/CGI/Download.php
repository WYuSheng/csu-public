<?php

namespace Gini\Controller\CGI;

class Download extends Layout\Home {

    function actionContent($id = 0) {
        $download = a('download', $id);
        if (!$download->id) {
            $this->redirect('error/404');
        }

        $fullpath = $download->src();
        $filename = $download->title;
        $filetype = $download->fileExtension;
        $mime_type = \Gini\File::mimeType($fullpath);
        header("Content-Type: $mime_type");
        header('Accept-Ranges: bytes');
        header('Accept-Length:'.filesize($fullpath));
        header("Content-Disposition: attachment; filename=\"$filename.$filetype\"");
        ob_clean();
        echo file_get_contents($fullpath);
        exit;
    }

}
