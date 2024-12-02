<?php

namespace MLL\Utils\ICA\Client\Requests\Project;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProject
 */
class GetProject extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}";
	}


	/**
	 * @param string $projectId
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
