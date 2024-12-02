<?php

namespace MLL\Utils\ICA\Client\Requests\EventCode;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getEventCodes
 */
class GetEventCodes extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/eventCodes";
	}


	public function __construct()
	{
	}
}
