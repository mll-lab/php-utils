<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataCopyBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectDataCopyBatch
 */
class GetProjectDataCopyBatch extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataCopyBatch/{$this->batchId}";
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
