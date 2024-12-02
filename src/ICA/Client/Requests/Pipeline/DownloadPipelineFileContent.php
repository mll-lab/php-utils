<?php

namespace MLL\Utils\ICA\Client\Requests\Pipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * downloadPipelineFileContent
 */
class DownloadPipelineFileContent extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/pipelines/{$this->pipelineId}/files/{$this->fileId}/content";
	}


	/**
	 * @param string $pipelineId The ID of the project pipeline to retrieve files for
	 * @param string $fileId The ID of the pipeline file
	 */
	public function __construct(
		protected string $pipelineId,
		protected string $fileId,
	) {
	}
}
