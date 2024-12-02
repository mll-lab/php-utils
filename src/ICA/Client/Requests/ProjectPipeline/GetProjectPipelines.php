<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectPipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectPipelines
 *
 * Lists all pipelines that are available to the project.
 */
class GetProjectPipelines extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/pipelines";
	}


	/**
	 * @param string $projectId The ID of the project to retrieve pipelines for
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
