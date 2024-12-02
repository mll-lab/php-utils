<?php

namespace MLL\Utils\ICA\Client\Requests\StorageCredentials;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createStorageCredential
 */
class CreateStorageCredential extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/storageCredentials";
	}


	public function __construct()
	{
	}
}
