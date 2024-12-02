<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectPipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectPipelineInputParameters
 *
 * The pipeline can originate from a linked bundle.
 */
class GetProjectPipelineInputParameters extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/pipelines/{$this->pipelineId}/inputParameters";
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to retrieve input parameters for
	 */
	public function __construct(
		protected string $projectId,
		protected string $pipelineId,
	) {
	}
}
