<?php

namespace MLL\Utils\ICA\Client\Requests\StorageBundle;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getStorageBundles
 */
class GetStorageBundles extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/storageBundles";
	}


	public function __construct()
	{
	}
}
