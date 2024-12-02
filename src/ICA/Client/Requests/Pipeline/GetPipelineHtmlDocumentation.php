<?php

namespace MLL\Utils\ICA\Client\Requests\Pipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getPipelineHtmlDocumentation
 *
 * Retrieve HTML documentation for a project pipeline. This can be a pipeline from a linked bundle.
 */
class GetPipelineHtmlDocumentation extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/pipelines/{$this->pipelineId}/documentation/HTML";
	}


	/**
	 * @param string $pipelineId The ID of the project pipeline to retrieve HTML documentation from
	 */
	public function __construct(
		protected string $pipelineId,
	) {
	}
}
