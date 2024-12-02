<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectAnalysis;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getAnalysisInputs
 */
class GetAnalysisInputs extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/analyses/{$this->analysisId}/inputs";
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis to retrieve the inputs for
	 */
	public function __construct(
		protected string $projectId,
		protected string $analysisId,
	) {
	}
}
