<?php

namespace MLL\Utils\ICA\Client\Requests\Connector;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getDownloadRules
 */
class GetDownloadRules extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/connectors/{$this->connectorId}/downloadRules";
	}


	/**
	 * @param string $connectorId
	 */
	public function __construct(
		protected string $connectorId,
	) {
	}
}
