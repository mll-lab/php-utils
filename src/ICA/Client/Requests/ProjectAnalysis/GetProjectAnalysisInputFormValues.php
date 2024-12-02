<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectAnalysis;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectAnalysisInputFormValues
 *
 * Retrieve the values from an input form of a JSON based pipeline used to start an analysis.
 */
class GetProjectAnalysisInputFormValues extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/analyses/{$this->analysisId}/inputFormValues";
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis to retrieve the input form values from
	 */
	public function __construct(
		protected string $projectId,
		protected string $analysisId,
	) {
	}
}
