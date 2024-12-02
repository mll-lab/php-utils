<?php

namespace MLL\Utils\ICA\Client\Requests\System;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getSystemInfo
 */
class GetSystemInfo extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/system/info";
	}


	public function __construct()
	{
	}
}
