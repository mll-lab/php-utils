<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectPermission;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createProjectPermission
 *
 * # Changelog
 * For this endpoint multiple versions exist. Note that the values for request headers
 * 'Content-Type' and 'Accept' must contain a matching version.
 *
 * ## [V3]
 * Initial version
 * ## [V4]
 * Added
 * 'Administrator' role for Bench.
 * The role attributes are strings instead of enums to support future
 * additions in a backward compatible manner.
 */
class CreateProjectPermission extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/permissions";
	}


	/**
	 * @param string $projectId
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
