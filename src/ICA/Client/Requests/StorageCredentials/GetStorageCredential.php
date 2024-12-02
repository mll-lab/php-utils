<?php

namespace MLL\Utils\ICA\Client\Requests\StorageCredentials;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getStorageCredential
 */
class GetStorageCredential extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/storageCredentials/{$this->storageCredentialId}";
	}


	/**
	 * @param string $storageCredentialId The ID of the storage credential to retrieve
	 */
	public function __construct(
		protected string $storageCredentialId,
	) {
	}
}
