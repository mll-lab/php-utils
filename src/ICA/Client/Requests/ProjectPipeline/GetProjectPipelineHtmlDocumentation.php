<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectPipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectPipelineHtmlDocumentation
 *
 * Retrieve HTML documentation for a project pipeline. This can be a pipeline from a linked bundle.
 */
class GetProjectPipelineHtmlDocumentation extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/pipelines/{$this->pipelineId}/documentation/HTML";
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to retrieve HTML documentation from
	 */
	public function __construct(
		protected string $projectId,
		protected string $pipelineId,
	) {
	}
}
