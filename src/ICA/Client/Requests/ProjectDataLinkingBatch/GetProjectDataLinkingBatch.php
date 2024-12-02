<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataLinkingBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectDataLinkingBatch
 */
class GetProjectDataLinkingBatch extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataLinkingBatch/{$this->batchId}";
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
