<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectSampleBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getSampleCreationBatchItem
 */
class GetSampleCreationBatchItem extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/sampleCreationBatch/{$this->batchId}/items/{$this->itemId}";
	}


	/**
	 * @param string $projectId
	 * @param string $batchId The ID of the sample creation batch
	 * @param string $itemId The ID of the sample creation batch item
	 */
	public function __construct(
		protected string $projectId,
		protected string $batchId,
		protected string $itemId,
	) {
	}
}
