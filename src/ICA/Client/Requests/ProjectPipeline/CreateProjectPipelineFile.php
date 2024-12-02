<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectPipeline;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createProjectPipelineFile
 */
class CreateProjectPipelineFile extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/pipelines/{$this->pipelineId}/files";
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to create a file for
	 */
	public function __construct(
		protected string $projectId,
		protected string $pipelineId,
	) {
	}
}
