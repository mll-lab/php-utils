<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataMoveBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectDataMoveBatch
 */
class GetProjectDataMoveBatch extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataMoveBatch/{$this->batchId}";
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
