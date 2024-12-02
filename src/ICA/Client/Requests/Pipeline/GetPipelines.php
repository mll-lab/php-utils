<?php

namespace MLL\Utils\ICA\Client\Requests\Pipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getPipelines
 *
 * Only lists pipelines that are owned by the user/tenant (not those to which a user is entitled).
 */
class GetPipelines extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/pipelines";
	}


	public function __construct()
	{
	}
}
