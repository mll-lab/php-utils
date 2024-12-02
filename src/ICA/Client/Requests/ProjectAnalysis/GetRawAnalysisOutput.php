<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectAnalysis;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getRawAnalysisOutput
 */
class GetRawAnalysisOutput extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/analyses/{$this->analysisId}/rawOutput";
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis for which to retrieve the raw output
	 */
	public function __construct(
		protected string $projectId,
		protected string $analysisId,
	) {
	}
}
