<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectAnalysis;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * abortAnalysis
 *
 * Endpoint for aborting an analysis. The status of the analysis is not updated immediately, only when
 * the abortion of the analysis has actually started.This is a non-RESTful endpoint, as the path of
 * this endpoint is not representing a REST resource.
 */
class AbortAnalysis extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/analyses/{$this->analysisIdAbort}";
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis to abort
	 */
	public function __construct(
		protected string $projectId,
		protected string $analysisId,
	) {
	}
}
