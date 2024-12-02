<?php

namespace MLL\Utils\ICA\Client\Requests\User;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getUsers
 */
class GetUsers extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/users";
	}


	/**
	 * @param null|string $emailAddress The email address to filter on
	 */
	public function __construct(
		protected ?string $emailAddress = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['emailAddress' => $this->emailAddress]);
	}
}
