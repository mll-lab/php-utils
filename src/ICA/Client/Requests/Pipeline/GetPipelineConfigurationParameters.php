<?php

namespace MLL\Utils\ICA\Client\Requests\Pipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getPipelineConfigurationParameters
 */
class GetPipelineConfigurationParameters extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/pipelines/{$this->pipelineId}/configurationParameters";
	}


	/**
	 * @param string $pipelineId
	 */
	public function __construct(
		protected string $pipelineId,
	) {
	}
}
