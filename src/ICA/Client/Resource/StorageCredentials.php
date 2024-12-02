<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\StorageCredentials\CreateStorageCredential;
use MLL\Utils\ICA\Client\Requests\StorageCredentials\GetStorageCredential;
use MLL\Utils\ICA\Client\Requests\StorageCredentials\GetStorageCredentials;
use MLL\Utils\ICA\Client\Requests\StorageCredentials\ShareStorageCredential;
use MLL\Utils\ICA\Client\Requests\StorageCredentials\UpdateStorageCredentialSecrets;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class StorageCredentials extends Resource
{
	public function getStorageCredentials(): Response
	{
		return $this->connector->send(new GetStorageCredentials());
	}


	public function createStorageCredential(): Response
	{
		return $this->connector->send(new CreateStorageCredential());
	}


	/**
	 * @param string $storageCredentialId The ID of the storage credential to retrieve
	 */
	public function getStorageCredential(string $storageCredentialId): Response
	{
		return $this->connector->send(new GetStorageCredential($storageCredentialId));
	}


	/**
	 * @param string $storageCredentialId The ID of the storage credential to share
	 */
	public function shareStorageCredential(string $storageCredentialId): Response
	{
		return $this->connector->send(new ShareStorageCredential($storageCredentialId));
	}


	/**
	 * @param string $storageCredentialId
	 */
	public function updateStorageCredentialSecrets(string $storageCredentialId): Response
	{
		return $this->connector->send(new UpdateStorageCredentialSecrets($storageCredentialId));
	}
}
