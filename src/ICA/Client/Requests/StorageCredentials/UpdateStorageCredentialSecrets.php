<?php

namespace MLL\Utils\ICA\Client\Requests\StorageCredentials;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * updateStorageCredentialSecrets
 *
 * When your storage credentials change or get updated due to security reasons you need to update them
 * here.
 */
class UpdateStorageCredentialSecrets extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/storageCredentials/{$this->storageCredentialIdUpdateSecrets}";
	}


	/**
	 * @param string $storageCredentialId
	 */
	public function __construct(
		protected string $storageCredentialId,
	) {
	}
}
