<?php

namespace Adnduweb\Ci4Core\Entities;

use CodeIgniter\Entity;

class Audit extends Entity
{	
    protected $dates = ['created_at'];
    
    public function getIdItem()
	{
		return $this->attributes['id'] ?? null;
    }
    
	public function setDateHumanize()
    {
        return $this->attributes['created_at']->humanize();
    }
}