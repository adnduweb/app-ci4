<?php

namespace Adnduweb\Ci4Core\Entities;

use CodeIgniter\Entity;
use Adnduweb\Ci4Core\Models\VisitModel;

class Visit extends Entity
{
	protected $dates = [
		'created_at',
		'verified_at',
	];

	// magic IP string/long converters
	public function setIpAddress($ipAddress)
	{
		if ($long = ip2long($ipAddress))
		{
			$this->attributes['ip_address'] = $long;
		}
		else
		{
			$this->attributes['ip_address'] = $ipAddress;
		}

		return $this;
	}

	public function getIpAddress(string $format = 'long')
	{
		if ($format === 'string')
		{
			return long2ip($this->attributes['ip_address']);
		}
		else
		{
			return $this->attributes['ip_address'];
		}
	}

	// search for a visit with similar characteristics to the current one
	public function getSimilar($trackingMethod, $resetMinutes = 60)
	{
		// required fields
		if (empty($this->host) || empty($this->path))
		{
			return false;
		}
		// require tracking field
		if (empty($this->{$trackingMethod}))
		{
			return false;
		}

		$visits = new VisitModel();
		// check for matching components within the last resetMinutes
		$since   = date('Y-m-d H:i:s', strtotime('-' . $resetMinutes . ' minutes'));
		$similar = $visits->where('host', $this->host)
			->where('path', $this->path)
			->where('query', (string)$this->query)
			->where($trackingMethod, $this->{$trackingMethod})
			->where('created_at >=', $since)
			->first();

		return $similar;
	}
}