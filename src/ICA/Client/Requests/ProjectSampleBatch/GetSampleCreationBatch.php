<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectSampleBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getSampleCreationBatch
 */
class GetSampleCreationBatch extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/sampleCreationBatch/{$this->batchId}";
	}


	/**
	 * @param string $projectId
	 * @param string $batchId The ID of the sample creation batch
	 */
	public function __construct(
		protected string $projectId,
		protected string $batchId,
	) {
	}
}
