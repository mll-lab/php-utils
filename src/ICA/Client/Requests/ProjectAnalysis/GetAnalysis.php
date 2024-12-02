<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectAnalysis;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getAnalysis
 *
 * # Changelog
 * For this endpoint multiple versions exist. Note that the values for request headers
 * 'Content-Type' and 'Accept' must contain a matching version.
 *
 * ## [V3]
 *  * Initial version
 * ## [V4]
 *  *
 * Field type 'status' changed from enum to String. New statuses have been added: ['QUEUED',
 * 'INITIALIZING', 'PREPARING_INPUTS', 'GENERATING_OUTPUTS', 'ABORTING'].
 *  * Field analysisPriority
 * changed from enum to String.
 *  * The owner and tenant are now represented by Identifier objects.
 */
class GetAnalysis extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/analyses/{$this->analysisId}";
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis to retrieve
	 */
	public function __construct(
		protected string $projectId,
		protected string $analysisId,
	) {
	}
}
