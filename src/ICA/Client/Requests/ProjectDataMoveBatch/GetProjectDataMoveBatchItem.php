<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataMoveBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectDataMoveBatchItem
 */
class GetProjectDataMoveBatchItem extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataMoveBatch/{$this->batchId}/items/{$this->itemId}";
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
