<?php

namespace MLL\Utils\ICA\Client\Requests\User;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * updateUser
 *
 * Fields which can be updated:
 * - greeting
 * - two factor authentication
 * - job title
 * - first name
 * - last
 * name
 * - mobile phone number
 * - phone number
 * - fax number
 * - address lines
 * - postal code
 * - city
 * -
 * country
 * - state
 */
class UpdateUser extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/users/{$this->userId}";
	}


	/**
	 * @param string $userId
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
