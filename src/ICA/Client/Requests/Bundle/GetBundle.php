<?php

namespace MLL\Utils\ICA\Client\Requests\Bundle;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBundle
 */
class GetBundle extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}";
	}


	/**
	 * @param string $bundleId The ID of the bundle to retrieve
	 */
	public function __construct(
		protected string $bundleId,
	) {
	}
}
