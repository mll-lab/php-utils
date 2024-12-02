<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\System\GetSystemInfo;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class System extends Resource
{
	public function getSystemInfo(): Response
	{
		return $this->connector->send(new GetSystemInfo());
	}
}
