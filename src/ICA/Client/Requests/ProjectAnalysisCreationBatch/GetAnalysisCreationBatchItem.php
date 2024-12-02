<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectAnalysisCreationBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getAnalysisCreationBatchItem
 *
 * # Changelog
 * For this endpoint multiple versions exist. Note that the values for request headers
 * 'Content-Type' and 'Accept' must contain a matching version.
 *
 * ## [V3]
 * Initial version
 * ## [V4]
 * Field
 * 'createdAnalysis' changes:
 *  * Field type 'status' changed from enum to String. New statuses have
 * been added: ['QUEUED', 'INITIALIZING', 'PREPARING_INPUTS', 'GENERATING_OUTPUTS', 'ABORTING'].
 *  *
 * Field analysisPriority changed from enum to String.
 *  * The owner and tenant are now represented by
 * Identifier objects.
 */
class GetAnalysisCreationBatchItem extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/analysisCreationBatch/{$this->batchId}/items/{$this->itemId}";
	}


	/**
	 * @param string $projectId
	 * @param string $batchId The ID of the analysis creation batch
	 * @param string $itemId The ID of the analysis creation batch item
	 */
	public function __construct(
		protected string $projectId,
		protected string $batchId,
		protected string $itemId,
	) {
	}
}
