<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectAnalysis;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getAnalysisConfigurations
 */
class GetAnalysisConfigurations extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/analyses/{$this->analysisId}/configurations";
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis to retrieve the configuration for
	 */
	public function __construct(
		protected string $projectId,
		protected string $analysisId,
	) {
	}
}
