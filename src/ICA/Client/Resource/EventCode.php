<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\EventCode\GetEventCodes;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class EventCode extends Resource
{
	public function getEventCodes(): Response
	{
		return $this->connector->send(new GetEventCodes());
	}
}
