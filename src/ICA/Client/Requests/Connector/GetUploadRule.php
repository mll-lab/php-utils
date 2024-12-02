<?php

namespace MLL\Utils\ICA\Client\Requests\Connector;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getUploadRule
 */
class GetUploadRule extends Request
{
	protected Method $method = Method::GET;


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
