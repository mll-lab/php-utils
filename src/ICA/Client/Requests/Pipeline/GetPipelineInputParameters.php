<?php

namespace MLL\Utils\ICA\Client\Requests\Pipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getPipelineInputParameters
 */
class GetPipelineInputParameters extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/pipelines/{$this->pipelineId}/inputParameters";
	}


	/**
	 * @param string $pipelineId The ID of the pipeline to retrieve input parameters for
	 */
	public function __construct(
		protected string $pipelineId,
	) {
	}
}
