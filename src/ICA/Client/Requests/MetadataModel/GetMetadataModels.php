<?php

namespace MLL\Utils\ICA\Client\Requests\MetadataModel;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getMetadataModels
 *
 * Retrieve the metadata models for the tenant associated to the security context. This call returns a
 * list of metadata models for the tenant in a non-hierarchical way. Instead of a model having a list
 * of child models all models except the root model have a parent model identifier. This can be used to
 * reconstruct the hierarchy.
 */
class GetMetadataModels extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/metadataModels";
	}


	public function __construct()
	{
	}
}
