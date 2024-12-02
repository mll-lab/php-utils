<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\StorageBundle\GetStorageBundles;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class StorageBundle extends Resource
{
	public function getStorageBundles(): Response
	{
		return $this->connector->send(new GetStorageBundles());
	}
}
