<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectAnalysisStorage;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectAnalysisStorageOptions
 */
class GetProjectAnalysisStorageOptions extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/analysisStorages";
	}


	/**
	 * @param string $projectId
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
