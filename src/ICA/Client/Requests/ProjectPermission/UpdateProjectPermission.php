<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectPermission;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * updateProjectPermission
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
 * Fields which can be updated:
 * - uploadAllowed
 * -
 * downloadAllowed
 * - roleProject
 * - roleFlow
 * - roleBase
 * - roleBench
 */
class UpdateProjectPermission extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/permissions/{$this->permissionId}";
	}


	/**
	 * @param string $projectId
	 * @param string $permissionId
	 */
	public function __construct(
		protected string $projectId,
		protected string $permissionId,
	) {
	}
}
