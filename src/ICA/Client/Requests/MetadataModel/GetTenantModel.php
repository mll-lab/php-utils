<?php

namespace MLL\Utils\ICA\Client\Requests\MetadataModel;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getTenantModel
 *
 * Retrieve the tenant model for the tenant associated to the security context. The tenant model is a
 * hierarchical structure where the top level tenant holds a list of child models (which in turn can
 * hold child models).
 */
class GetTenantModel extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/metadataModels/tenantModel";
	}


	public function __construct()
	{
	}
}
