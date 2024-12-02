<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectPipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectPipelineReferenceSets
 *
 * Retrieve the reference sets of a project pipeline. This can be a pipeline from a linked bundle.
 */
class GetProjectPipelineReferenceSets extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/pipelines/{$this->pipelineId}/referenceSets";
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the pipeline to retrieve reference sets for
	 */
	public function __construct(
		protected string $projectId,
		protected string $pipelineId,
	) {
	}
}
