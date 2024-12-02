<?php

namespace MLL\Utils\ICA\Client\Requests\Connector;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createDownloadRule
 */
class CreateDownloadRule extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


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
