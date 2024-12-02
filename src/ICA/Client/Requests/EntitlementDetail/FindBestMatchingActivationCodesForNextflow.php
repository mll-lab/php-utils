<?php

namespace MLL\Utils\ICA\Client\Requests\EntitlementDetail;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * findBestMatchingActivationCodesForNextflow
 *
 * Endpoint for searching the best activation code details for a project and an analysis for a Nextflow
 * pipeline.This is a non-RESTful endpoint, as the path of this endpoint is not representing a REST
 * resource.
 */
class FindBestMatchingActivationCodesForNextflow extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/activationCodes:findBestMatchingForNextflow";
	}


	public function __construct()
	{
	}
}
