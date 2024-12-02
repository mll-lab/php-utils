<?php

namespace MLL\Utils\ICA\Client\Requests\StorageConfiguration;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createStorageConfiguration
 */
class CreateStorageConfiguration extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/storageConfigurations";
	}


	public function __construct()
	{
	}
}
