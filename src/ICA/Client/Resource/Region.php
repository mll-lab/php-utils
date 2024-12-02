<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\Region\GetRegion;
use MLL\Utils\ICA\Client\Requests\Region\GetRegions;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class Region extends Resource
{
	public function getRegions(): Response
	{
		return $this->connector->send(new GetRegions());
	}


	/**
	 * @param string $regionId
	 */
	public function getRegion(string $regionId): Response
	{
		return $this->connector->send(new GetRegion($regionId));
	}
}
