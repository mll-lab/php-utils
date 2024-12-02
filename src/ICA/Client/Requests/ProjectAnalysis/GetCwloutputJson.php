<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectAnalysis;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getCWLOutputJson
 */
class GetCwloutputJson extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/analyses/{$this->analysisId}/cwl/outputJson";
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the CWL analysis for which to retrieve the output json
	 */
	public function __construct(
		protected string $projectId,
		protected string $analysisId,
	) {
	}
}
