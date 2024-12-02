<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\MetadataModel\GetMetadataModel;
use MLL\Utils\ICA\Client\Requests\MetadataModel\GetMetadataModelFields;
use MLL\Utils\ICA\Client\Requests\MetadataModel\GetMetadataModels;
use MLL\Utils\ICA\Client\Requests\MetadataModel\GetTenantModel;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class MetadataModel extends Resource
{
	public function getMetadataModels(): Response
	{
		return $this->connector->send(new GetMetadataModels());
	}


	/**
	 * @param string $metadataModelId
	 */
	public function getMetadataModel(string $metadataModelId): Response
	{
		return $this->connector->send(new GetMetadataModel($metadataModelId));
	}


	/**
	 * @param string $metadataModelId
	 */
	public function getMetadataModelFields(string $metadataModelId): Response
	{
		return $this->connector->send(new GetMetadataModelFields($metadataModelId));
	}


	public function getTenantModel(): Response
	{
		return $this->connector->send(new GetTenantModel());
	}
}
