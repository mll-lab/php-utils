<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectPipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteProjectPipelineFile
 */
class DeleteProjectPipelineFile extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/pipelines/{$this->pipelineId}/files/{$this->fileId}";
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to delete a file for
	 * @param string $fileId The ID of the pipeline file
	 */
	public function __construct(
		protected string $projectId,
		protected string $pipelineId,
		protected string $fileId,
	) {
	}
}
