<?php

namespace MLL\Utils\ICA\Client\Requests\Connector;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteDownloadRule
 */
class DeleteDownloadRule extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/connectors/{$this->connectorId}/downloadRules/{$this->downloadRuleId}";
	}


	/**
	 * @param string $connectorId
	 * @param string $downloadRuleId
	 */
	public function __construct(
		protected string $connectorId,
		protected string $downloadRuleId,
	) {
	}
}
