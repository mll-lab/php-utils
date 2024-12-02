<?php

namespace MLL\Utils\ICA\Client\Requests\Connector;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * updateUploadRule
 *
 * Fields which can be updated:
 *  - code
 *  - active
 *  - description
 *  - localFolder
 *  - filePattern
 *  -
 * dataFormat
 */
class UpdateUploadRule extends Request
{
	protected Method $method = Method::PUT;


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
