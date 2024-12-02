<?php

namespace MLL\Utils\ICA\Client\Requests\PipelineLanguage;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getNextflowVersions
 */
class GetNextflowVersions extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/pipelineLanguages/nextflow/versions";
	}


	public function __construct()
	{
	}
}
