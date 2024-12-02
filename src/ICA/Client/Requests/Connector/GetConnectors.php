<?php

namespace MLL\Utils\ICA\Client\Requests\Connector;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getConnectors
 */
class GetConnectors extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/connectors";
	}


	/**
	 * @param null|bool $activeOnly When true only the active connectors will be returned. When false (default value) all connectors wil be returned.
	 */
	public function __construct(
		protected ?bool $activeOnly = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['activeOnly' => $this->activeOnly]);
	}
}
