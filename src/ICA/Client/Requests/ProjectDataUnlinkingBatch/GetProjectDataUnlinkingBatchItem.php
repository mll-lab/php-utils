<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataUnlinkingBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectDataUnlinkingBatchItem
 */
class GetProjectDataUnlinkingBatchItem extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataUnlinkingBatch/{$this->batchId}/items/{$this->itemId}";
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
