<?php

namespace MLL\Utils\ICA\Client\Requests\AnalysisStorage;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getAnalysisStorageOptions
 *
 * This endpoint only returns V3 items. Use the search project analysis storage endpoint to get V4
 * items.
 */
class GetAnalysisStorageOptions extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/analysisStorages";
	}


	public function __construct()
	{
	}
}
