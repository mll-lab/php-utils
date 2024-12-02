<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\Connector\CancelConnector;
use MLL\Utils\ICA\Client\Requests\Connector\CreateConnector;
use MLL\Utils\ICA\Client\Requests\Connector\CreateDownloadRule;
use MLL\Utils\ICA\Client\Requests\Connector\CreateUploadRule;
use MLL\Utils\ICA\Client\Requests\Connector\DeleteDownloadRule;
use MLL\Utils\ICA\Client\Requests\Connector\DeleteUploadRule;
use MLL\Utils\ICA\Client\Requests\Connector\DisableConnector;
use MLL\Utils\ICA\Client\Requests\Connector\EnableConnector;
use MLL\Utils\ICA\Client\Requests\Connector\GetConnector;
use MLL\Utils\ICA\Client\Requests\Connector\GetConnectors;
use MLL\Utils\ICA\Client\Requests\Connector\GetDownloadRule;
use MLL\Utils\ICA\Client\Requests\Connector\GetDownloadRules;
use MLL\Utils\ICA\Client\Requests\Connector\GetUploadRule;
use MLL\Utils\ICA\Client\Requests\Connector\GetUploadRules;
use MLL\Utils\ICA\Client\Requests\Connector\UpdateDownloadRule;
use MLL\Utils\ICA\Client\Requests\Connector\UpdateUploadRule;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class Connector extends Resource
{
	/**
	 * @param bool $activeOnly When true only the active connectors will be returned. When false (default value) all connectors wil be returned.
	 */
	public function getConnectors(?bool $activeOnly): Response
	{
		return $this->connector->send(new GetConnectors($activeOnly));
	}


	public function createConnector(): Response
	{
		return $this->connector->send(new CreateConnector());
	}


	/**
	 * @param string $connectorId
	 */
	public function getConnector(string $connectorId): Response
	{
		return $this->connector->send(new GetConnector($connectorId));
	}


	/**
	 * @param string $connectorId
	 */
	public function getUploadRules(string $connectorId): Response
	{
		return $this->connector->send(new GetUploadRules($connectorId));
	}


	/**
	 * @param string $connectorId
	 */
	public function createUploadRule(string $connectorId): Response
	{
		return $this->connector->send(new CreateUploadRule($connectorId));
	}


	/**
	 * @param string $connectorId
	 * @param string $uploadRuleId
	 */
	public function getUploadRule(string $connectorId, string $uploadRuleId): Response
	{
		return $this->connector->send(new GetUploadRule($connectorId, $uploadRuleId));
	}


	/**
	 * @param string $connectorId
	 * @param string $uploadRuleId
	 */
	public function updateUploadRule(string $connectorId, string $uploadRuleId): Response
	{
		return $this->connector->send(new UpdateUploadRule($connectorId, $uploadRuleId));
	}


	/**
	 * @param string $connectorId
	 * @param string $uploadRuleId
	 */
	public function deleteUploadRule(string $connectorId, string $uploadRuleId): Response
	{
		return $this->connector->send(new DeleteUploadRule($connectorId, $uploadRuleId));
	}


	/**
	 * @param string $connectorId
	 */
	public function getDownloadRules(string $connectorId): Response
	{
		return $this->connector->send(new GetDownloadRules($connectorId));
	}


	/**
	 * @param string $connectorId
	 */
	public function createDownloadRule(string $connectorId): Response
	{
		return $this->connector->send(new CreateDownloadRule($connectorId));
	}


	/**
	 * @param string $connectorId
	 * @param string $downloadRuleId
	 */
	public function getDownloadRule(string $connectorId, string $downloadRuleId): Response
	{
		return $this->connector->send(new GetDownloadRule($connectorId, $downloadRuleId));
	}


	/**
	 * @param string $connectorId
	 * @param string $downloadRuleId
	 */
	public function updateDownloadRule(string $connectorId, string $downloadRuleId): Response
	{
		return $this->connector->send(new UpdateDownloadRule($connectorId, $downloadRuleId));
	}


	/**
	 * @param string $connectorId
	 * @param string $downloadRuleId
	 */
	public function deleteDownloadRule(string $connectorId, string $downloadRuleId): Response
	{
		return $this->connector->send(new DeleteDownloadRule($connectorId, $downloadRuleId));
	}


	/**
	 * @param string $connectorId
	 */
	public function cancelConnector(string $connectorId): Response
	{
		return $this->connector->send(new CancelConnector($connectorId));
	}


	/**
	 * @param string $connectorId
	 */
	public function enableConnector(string $connectorId): Response
	{
		return $this->connector->send(new EnableConnector($connectorId));
	}


	/**
	 * @param string $connectorId
	 */
	public function disableConnector(string $connectorId): Response
	{
		return $this->connector->send(new DisableConnector($connectorId));
	}
}
