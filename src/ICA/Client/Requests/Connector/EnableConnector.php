<?php

namespace MLL\Utils\ICA\Client\Requests\Connector;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * enableConnector
 *
 * Endpoint for enabling a connector. This is a non-RESTful endpoint, as the path of this endpoint is
 * not representing a REST resource.
 */
class EnableConnector extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/connectors/{$this->connectorIdEnable}";
	}


	/**
	 * @param string $connectorId
	 */
	public function __construct(
		protected string $connectorId,
	) {
	}
}
