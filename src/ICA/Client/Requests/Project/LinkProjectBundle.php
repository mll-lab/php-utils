<?php

namespace MLL\Utils\ICA\Client\Requests\Project;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * linkProjectBundle
 */
class LinkProjectBundle extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


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
