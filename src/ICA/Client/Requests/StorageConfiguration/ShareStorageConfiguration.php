<?php

namespace MLL\Utils\ICA\Client\Requests\StorageConfiguration;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * shareStorageConfiguration
 *
 * Here you share your own storage configuration with all the other users in your tenant.
 */
class ShareStorageConfiguration extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/storageConfigurations/{$this->storageConfigurationIdShare}";
	}


	/**
	 * @param string $storageConfigurationId The ID of the storage configuration to share
	 */
	public function __construct(
		protected string $storageConfigurationId,
	) {
	}
}
