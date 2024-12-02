<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectAnalysisCreationBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getAnalysisCreationBatch
 */
class GetAnalysisCreationBatch extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/analysisCreationBatch/{$this->batchId}";
	}


	/**
	 * @param string $projectId
	 * @param string $batchId The ID of the analysis creation batch
	 */
	public function __construct(
		protected string $projectId,
		protected string $batchId,
	) {
	}
}
