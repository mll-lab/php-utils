<?php

namespace MLL\Utils\ICA\Client\Requests\Connector;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteUploadRule
 */
class DeleteUploadRule extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/connectors/{$this->connectorId}/uploadRules/{$this->uploadRuleId}";
	}


	/**
	 * @param string $connectorId
	 * @param string $uploadRuleId
	 */
	public function __construct(
		protected string $connectorId,
		protected string $uploadRuleId,
	) {
	}
}
