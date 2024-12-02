<?php

namespace MLL\Utils\ICA\Client\Requests\Pipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getPipelineReferenceSets
 */
class GetPipelineReferenceSets extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/pipelines/{$this->pipelineId}/referenceSets";
	}


	/**
	 * @param string $pipelineId The ID of the pipeline to retrieve reference sets for
	 */
	public function __construct(
		protected string $pipelineId,
	) {
	}
}
