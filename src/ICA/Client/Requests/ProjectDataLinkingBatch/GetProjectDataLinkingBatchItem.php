<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataLinkingBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectDataLinkingBatchItem
 *
 * # Changelog
 * For this endpoint multiple versions exist. Note that the values for request headers
 * 'Content-Type' and 'Accept' must contain a matching version.
 *
 * ## [V3]
 * Initial version, deprecated,
 * returns PARTIALLY_LINKED item processing status as FAILED.
 * ## [V4]
 * Supports PARTIALLY_LINKED item
 * processing status.
 */
class GetProjectDataLinkingBatchItem extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataLinkingBatch/{$this->batchId}/items/{$this->itemId}";
	}


	/**
	 * @param string $projectId
	 * @param string $batchId
	 * @param string $itemId
	 */
	public function __construct(
		protected string $projectId,
		protected string $batchId,
		protected string $itemId,
	) {
	}
}
