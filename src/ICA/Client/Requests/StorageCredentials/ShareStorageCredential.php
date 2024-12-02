<?php

namespace MLL\Utils\ICA\Client\Requests\StorageCredentials;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * shareStorageCredential
 *
 * Here you share your own storage credentials with all the other users in your tenant.
 */
class ShareStorageCredential extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/storageCredentials/{$this->storageCredentialIdShare}";
	}


	/**
	 * @param string $storageCredentialId The ID of the storage credential to share
	 */
	public function __construct(
		protected string $storageCredentialId,
	) {
	}
}
