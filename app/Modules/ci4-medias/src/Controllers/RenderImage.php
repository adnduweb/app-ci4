<?php

namespace Adnduweb\Ci4Medias\Controllers;

class RenderImage extends \CodeIgniter\Controller
{

    public $directory; 

    public $dimension; 

    public $extension; 

    public $filename; 

    public $image; 

    public $newFile; 

    public function index(string $directory , string $file)
    {
        $this->directory = $directory;

        switch ($this->directory) {
            case 'thumbnails':
                $this->newFile = $this->getSizeDefault($file);
                break;
            case 'small':
                $this->newFile = $this->getSizeDefault($file);
                break;
            case 'medium':
                $this->newFile = $this->getSizeDefault($file);
                break;
            case 'large':
                $this->newFile = $this->getSizeDefault($file);
                break;
            case 'original':
                $this->newFile = $this->getSizeDefault($file);
                break;
            case 'custom':

                $segment = explode('-', $file);
                list($this->dimension, $this->extension) = explode('.', end($segment));
                $file = str_replace('-' . $this->dimension, '', $file);

                if(!$this->filename = model(\Adnduweb\Ci4Medias\Models\MediaModel::class)->getMediaByFilename($file)){
                    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
                }
               
                if(($this->image = @file_get_contents(WRITEPATH.'medias/'.$this->directory.'/'.$this->filename. '-' . $this->dimension)) === FALSE)
                    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
                
                $this->newFile = $this->filename . '-' . $this->dimension;
                break;
            default:
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
           // break;
        }
    
           
        $file = new \CodeIgniter\Files\File(WRITEPATH.'medias/'.$this->directory.'/'.$this->newFile);
        //print_r($file); exit;

        // choose the right mime type
        $mimeType = $file->getMimeType();

        $this->response
            ->setStatusCode(200)
            ->setContentType($mimeType)
            ->setBody($this->image)
            ->send();

    }

    public function module(...$param){

        print_r($param); exit;

        $file = new \CodeIgniter\Files\File(WRITEPATH.'medias' . DIRECTORY_SEPARATOR . $directory. DIRECTORY_SEPARATOR . $secondDirectory . DIRECTORY_SEPARATOR . $file);
        $this->image = @file_get_contents($file->getPathname());

         $mimeType = $file->getMimeType();
         
         $this->response
             ->setStatusCode(200)
             ->setContentType($mimeType)
             ->setBody($this->image)
             ->send();
    }

    public function getSizeDefault(string $file){
        if(!$this->filename = model(\Adnduweb\Ci4Medias\Models\MediaModel::class)->getMediaByFilename($file))
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
           

        if(($this->image = @file_get_contents(WRITEPATH.'medias/'.$this->directory.'/'.$this->filename)) === FALSE)
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            return $this->filename;
    }

}