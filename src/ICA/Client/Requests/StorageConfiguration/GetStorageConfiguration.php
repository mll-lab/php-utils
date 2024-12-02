<?php

namespace MLL\Utils\ICA\Client\Requests\StorageConfiguration;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getStorageConfiguration
 */
class GetStorageConfiguration extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/storageConfigurations/{$this->storageConfigurationId}";
	}


	/**
	 * @param string $storageConfigurationId The ID of the storage configuration to retrieve
	 */
	public function __construct(
		protected string $storageConfigurationId,
	) {
	}
}
