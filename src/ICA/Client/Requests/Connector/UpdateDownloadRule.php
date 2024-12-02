<?php

namespace MLL\Utils\ICA\Client\Requests\Connector;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * updateDownloadRule
 *
 * Fields which can be updated:
 *  - code
 *  - active
 *  - description
 *  - sequence
 *  - formatCode
 *  -
 * projectName
 *  - targetLocalFolder
 *  - protocol
 *  - fileNameExpression
 *  - disableHashing
 */
class UpdateDownloadRule extends Request
{
	protected Method $method = Method::PUT;


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
