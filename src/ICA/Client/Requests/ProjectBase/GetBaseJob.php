<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectBase;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBaseJob
 */
class GetBaseJob extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/base/jobs/{$this->baseJobId}";
	}


	/**
	 * @param string $projectId
	 * @param string $baseJobId
	 */
	public function __construct(
		protected string $projectId,
		protected string $baseJobId,
	) {
	}
}
