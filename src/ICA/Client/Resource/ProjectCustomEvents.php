<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectCustomEvents\CreateCustomEvent;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectCustomEvents extends Resource
{
	/**
	 * @param string $projectId
	 */
	public function createCustomEvent(string $projectId): Response
	{
		return $this->connector->send(new CreateCustomEvent($projectId));
	}
}
