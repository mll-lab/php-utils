<?php

namespace MLL\Utils\ICA\Client\Requests\ReferenceSet;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getReferenceSets
 */
class GetReferenceSets extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/referenceSets";
	}


	public function __construct()
	{
	}
}
