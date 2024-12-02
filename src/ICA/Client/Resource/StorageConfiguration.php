<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\StorageConfiguration\CreateStorageConfiguration;
use MLL\Utils\ICA\Client\Requests\StorageConfiguration\GetStorageConfiguration;
use MLL\Utils\ICA\Client\Requests\StorageConfiguration\GetStorageConfigurationDetails;
use MLL\Utils\ICA\Client\Requests\StorageConfiguration\GetStorageConfigurations;
use MLL\Utils\ICA\Client\Requests\StorageConfiguration\ShareStorageConfiguration;
use MLL\Utils\ICA\Client\Requests\StorageConfiguration\ValidateStorageConfiguration;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class StorageConfiguration extends Resource
{
	public function getStorageConfigurations(): Response
	{
		return $this->connector->send(new GetStorageConfigurations());
	}


	public function createStorageConfiguration(): Response
	{
		return $this->connector->send(new CreateStorageConfiguration());
	}


	/**
	 * @param string $storageConfigurationId The ID of the storage configuration to retrieve
	 */
	public function getStorageConfiguration(string $storageConfigurationId): Response
	{
		return $this->connector->send(new GetStorageConfiguration($storageConfigurationId));
	}


	/**
	 * @param string $storageConfigurationId The ID of the storage configuration to retrieve
	 */
	public function getStorageConfigurationDetails(string $storageConfigurationId): Response
	{
		return $this->connector->send(new GetStorageConfigurationDetails($storageConfigurationId));
	}


	/**
	 * @param string $storageConfigurationId The ID of the storage configuration to share
	 */
	public function shareStorageConfiguration(string $storageConfigurationId): Response
	{
		return $this->connector->send(new ShareStorageConfiguration($storageConfigurationId));
	}


	/**
	 * @param string $storageConfigurationId The ID of the storage configuration to validate
	 */
	public function validateStorageConfiguration(string $storageConfigurationId): Response
	{
		return $this->connector->send(new ValidateStorageConfiguration($storageConfigurationId));
	}
}
