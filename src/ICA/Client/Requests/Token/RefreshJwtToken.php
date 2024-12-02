<?php

namespace MLL\Utils\ICA\Client\Requests\Token;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * refreshJwtToken
 *
 * When still having a valid JWT, this endpoint can be used to extend the validity.<br>Refreshing the
 * JWT is not possible if it has been created using an API-key.
 */
class RefreshJwtToken extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/tokens:refresh";
	}


	public function __construct()
	{
	}
}
