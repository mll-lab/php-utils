<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectPipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectPipeline
 *
 * Retrieves a project pipeline. This can be a pipeline from a linked bundle or an entitled, unlinked
 * bundle.
 */
class GetProjectPipeline extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/pipelines/{$this->pipelineId}";
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to retrieve
	 */
	public function __construct(
		protected string $projectId,
		protected string $pipelineId,
	) {
	}
}
