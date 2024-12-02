<?php

namespace MLL\Utils\ICA\Client\Requests\Token;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createJwtToken
 *
 * Generate a JWT using an API-key, Basic Authentication or a psToken. When using Basic Authentication,
 * and you are member of several tenants, also provide the tenant request parameter to indicate for
 * which tenant you want to authenticate. Note that Basic Authentication will not work for SSO (Single
 * Sign On) enabled authentication.
 */
class CreateJwtToken extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/tokens";
	}


	/**
	 * @param null|string $tenant The name of your tenant in case you have access to multiple tenants.
	 */
	public function __construct(
		protected ?string $tenant = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['tenant' => $this->tenant]);
	}
}
