<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataUnlinkingBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectDataUnlinkingBatch
 */
class GetProjectDataUnlinkingBatch extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataUnlinkingBatch/{$this->batchId}";
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
