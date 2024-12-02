<?php

namespace MLL\Utils\ICA\Client\Requests\Pipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getPipelineFiles
 */
class GetPipelineFiles extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/pipelines/{$this->pipelineId}/files";
	}


	/**
	 * @param string $pipelineId The ID of the project pipeline to retrieve files for
	 */
	public function __construct(
		protected string $pipelineId,
	) {
	}
}
