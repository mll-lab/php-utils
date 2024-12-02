<?php

namespace MLL\Utils\ICA\Client\Requests\Bundle;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBundleTermsOfUse
 */
class GetBundleTermsOfUse extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/termsOfUse";
	}


	/**
	 * @param string $bundleId The ID of the bundle of the terms of use to retrieve
	 */
	public function __construct(
		protected string $bundleId,
	) {
	}
}
