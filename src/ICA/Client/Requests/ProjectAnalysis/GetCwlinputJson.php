<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectAnalysis;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getCWLInputJson
 */
class GetCwlinputJson extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/analyses/{$this->analysisId}/cwl/inputJson";
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the CWL analysis for which to retrieve the input json
	 */
	public function __construct(
		protected string $projectId,
		protected string $analysisId,
	) {
	}
}
