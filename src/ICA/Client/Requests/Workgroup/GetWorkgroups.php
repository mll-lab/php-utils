<?php

namespace MLL\Utils\ICA\Client\Requests\Workgroup;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getWorkgroups
 */
class GetWorkgroups extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/workgroups";
	}


	public function __construct()
	{
	}
}
