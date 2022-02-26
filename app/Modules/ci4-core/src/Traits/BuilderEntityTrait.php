<?php

namespace Adnduweb\Ci4Core\Traits;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Config\Services;
use Adnduweb\Ci4Core\Entities\Builder;
use Adnduweb\Ci4Core\Models\BuilderModel;
use Adnduweb\Ci4Core\Exceptions\DataException;

trait BuilderEntityTrait
{

    public function getID(){
        return isset($this->attributes['id']) ? ucfirst($this->attributes['id']) : '';
    }

    public function getName(){
        return isset($this->attributes['name']) ? ucfirst($this->attributes['name']) : '';
    }

    public function getFullName(){
        return isset($this->attributes['name']) ? ucfirst($this->attributes['name']) : '';
    }

    public function getHandle(){
        return isset($this->attributes['handle']) ? ucfirst($this->attributes['handle']) : '';
    }

    public function getHomePage(){
        return ($this->attributes['id'] == '1') ? true : false;;
    }

    public function getTitle(){
        return isset($this->attributes['name']) ? ucfirst($this->attributes['name']) : '';
    }

    public function getDescription(){
        return  isset($this->attributes['description']) ? $this->attributes['description'] : '';
    }

    public function getDateUpdatedTime(){
        return str_replace(' ', 'T', $this->attributes['updated_at']) . '+00:00';
    }

    public function getActive(){
        return isset($this->attributes['active']) ? $this->attributes['active'] : '';
    }   

    public function getDisplayTitle(){
        return isset($this->attributes['display_title']) && $this->attributes['display_title'] == 1 ? 1 : 0;
    }   
    
    public function getTemplate(){
        return isset($this->attributes['template']) ? $this->attributes['template'] : '';
    } 

    public function getMetaTitle(){
        return isset($this->attributes['meta_title']) ? $this->attributes['meta_title'] : '';
    } 

    public function getMetaDescription(){
        return isset($this->attributes['meta_description']) ? $this->attributes['meta_description'] : '';
    } 

    public function getRobots(){
        return isset($this->attributes['robots']) ? $this->attributes['robots'] : '';
    } 

    public function getMeta( string $meta){
        return isset($this->attributes[$meta]) ? $this->attributes[$meta] : '';
    } 

    public function getSlug(){
        return isset($this->attributes['slug']) ? $this->attributes['slug'] : '';
    } 

    public function getPageBuilder(){
       if(isset($this->attributes['id'])){
            return $this->attributes['page_builder'] = model(PageModel::class)->getPageBuilder($this->attributes['id']);
       }
    } 

     /**
     * Activate item.
     *
     * @return $this
     */
    public function activate()
    {
        $this->attributes['active'] = 1;

        return $this;
    }

    
     /**
     * Activate item.
     *
     * @return $this
     */
    public function desactivate()
    {
        $this->attributes['active'] = 0;

        return $this;
    }
}
