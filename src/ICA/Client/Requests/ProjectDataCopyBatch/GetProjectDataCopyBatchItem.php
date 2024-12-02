<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataCopyBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectDataCopyBatchItem
 */
class GetProjectDataCopyBatchItem extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataCopyBatch/{$this->batchId}/items/{$this->itemId}";
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
