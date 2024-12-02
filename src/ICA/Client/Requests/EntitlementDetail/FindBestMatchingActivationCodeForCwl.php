<?php

namespace MLL\Utils\ICA\Client\Requests\EntitlementDetail;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * findBestMatchingActivationCodeForCwl
 *
 * Endpoint for searching the best activation code detail for a project and an analysis from a Cwl
 * pipeline.This is a non-RESTful endpoint, as the path of this endpoint is not representing a REST
 * resource.
 */
class FindBestMatchingActivationCodeForCwl extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/activationCodes:findBestMatchingForCwl";
	}


	public function __construct()
	{
	}
}
