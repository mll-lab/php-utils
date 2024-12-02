<?php

namespace MLL\Utils\ICA\Client\Requests\Region;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getRegions
 */
class GetRegions extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/regions";
	}


	public function __construct()
	{
	}
}
