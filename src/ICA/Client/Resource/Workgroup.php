<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\Workgroup\GetWorkgroup;
use MLL\Utils\ICA\Client\Requests\Workgroup\GetWorkgroups;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class Workgroup extends Resource
{
	public function getWorkgroups(): Response
	{
		return $this->connector->send(new GetWorkgroups());
	}


	/**
	 * @param string $workgroupId The ID of the workgroup to retrieve
	 */
	public function getWorkgroup(string $workgroupId): Response
	{
		return $this->connector->send(new GetWorkgroup($workgroupId));
	}
}
