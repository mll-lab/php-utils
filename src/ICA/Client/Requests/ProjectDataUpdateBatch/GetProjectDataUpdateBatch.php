<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataUpdateBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectDataUpdateBatch
 */
class GetProjectDataUpdateBatch extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataUpdateBatch/{$this->batchId}";
	}


	/**
	 * @param string $projectId
	 * @param string $batchId
	 */
	public function __construct(
		protected string $projectId,
		protected string $batchId,
	) {
	}
}
