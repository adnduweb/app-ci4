<?php

namespace Adnduweb\Ci4Core\Controllers;

class RenderImage extends \CodeIgniter\Controller
{
    public function index($imageName)
    {
        if(($image = file_get_contents(WRITEPATH.'uploads/front/'.$imageName)) === FALSE)
            show_404();

        $file = new \CodeIgniter\Files\File(WRITEPATH.'uploads/front/'.$imageName);

        // choose the right mime type
        $mimeType = $file->getMimeType();

        $this->response
            ->setStatusCode(200)
            ->setContentType($mimeType)
            ->setBody($image)
            ->send();

    }

}