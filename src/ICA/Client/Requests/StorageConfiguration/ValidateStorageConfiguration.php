<?php

namespace MLL\Utils\ICA\Client\Requests\StorageConfiguration;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * validateStorageConfiguration
 *
 * Here you start the validation of your storage configuration.
 */
class ValidateStorageConfiguration extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/storageConfigurations/{$this->storageConfigurationIdValidate}";
	}


	/**
	 * @param string $storageConfigurationId The ID of the storage configuration to validate
	 */
	public function __construct(
		protected string $storageConfigurationId,
	) {
	}
}
