<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\PipelineLanguage\GetNextflowVersions;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class PipelineLanguage extends Resource
{
	public function getNextflowVersions(): Response
	{
		return $this->connector->send(new GetNextflowVersions());
	}
}
