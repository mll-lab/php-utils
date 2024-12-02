<?php

namespace MLL\Utils\ICA\Client\Requests\Pipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getPipeline
 */
class GetPipeline extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/pipelines/{$this->pipelineId}";
	}


	/**
	 * @param string $pipelineId The ID of the pipeline to retrieve
	 */
	public function __construct(
		protected string $pipelineId,
	) {
	}
}
