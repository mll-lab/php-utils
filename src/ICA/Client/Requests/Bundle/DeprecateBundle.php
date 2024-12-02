<?php

namespace MLL\Utils\ICA\Client\Requests\Bundle;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * deprecateBundle
 */
class DeprecateBundle extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleIdDeprecate}";
	}


	/**
	 * @param string $bundleId The ID of the bundle to deprecate.
	 */
	public function __construct(
		protected string $bundleId,
	) {
	}
}
