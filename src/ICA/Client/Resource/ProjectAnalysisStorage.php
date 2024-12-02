<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectAnalysisStorage\GetProjectAnalysisStorageOptions;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectAnalysisStorage extends Resource
{
	/**
	 * @param string $projectId
	 */
	public function getProjectAnalysisStorageOptions(string $projectId): Response
	{
		return $this->connector->send(new GetProjectAnalysisStorageOptions($projectId));
	}
}
