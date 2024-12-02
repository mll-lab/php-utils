<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectPipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * downloadProjectPipelineFileContent
 */
class DownloadProjectPipelineFileContent extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/pipelines/{$this->pipelineId}/files/{$this->fileId}/content";
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to retrieve files for
	 * @param string $fileId The ID of the pipeline file
	 */
	public function __construct(
		protected string $projectId,
		protected string $pipelineId,
		protected string $fileId,
	) {
	}
}
