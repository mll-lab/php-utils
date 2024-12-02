<?php

namespace MLL\Utils\ICA\Client\Requests\User;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * revokeTenantAdminRightsToUser
 *
 * Endpoint for revoking tenant administrator rights to a user.This is a non-RESTful endpoint, as the
 * path of this endpoint is not representing a REST resource.
 */
class RevokeTenantAdminRightsToUser extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/users/{$this->userIdRevokeTenantAdministratorRights}";
	}


	/**
	 * @param string $userId
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
