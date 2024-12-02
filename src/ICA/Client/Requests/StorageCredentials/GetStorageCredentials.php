<?php

namespace MLL\Utils\ICA\Client\Requests\StorageCredentials;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getStorageCredentials
 */
class GetStorageCredentials extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/storageCredentials";
	}


	public function __construct()
	{
	}
}
