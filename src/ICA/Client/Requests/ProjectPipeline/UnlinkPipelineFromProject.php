<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectPipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * unlinkPipelineFromProject
 */
class UnlinkPipelineFromProject extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/pipelines/{$this->pipelineId}";
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the pipeline
	 */
	public function __construct(
		protected string $projectId,
		protected string $pipelineId,
	) {
	}
}
