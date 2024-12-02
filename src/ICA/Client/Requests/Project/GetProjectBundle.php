<?php

namespace MLL\Utils\ICA\Client\Requests\Project;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectBundle
 */
class GetProjectBundle extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/bundles/{$this->bundleId}";
	}


	/**
	 * @param string $projectId
	 * @param string $bundleId
	 */
	public function __construct(
		protected string $projectId,
		protected string $bundleId,
	) {
	}
}
