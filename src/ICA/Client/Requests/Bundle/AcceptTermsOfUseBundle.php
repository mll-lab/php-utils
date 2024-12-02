<?php

namespace MLL\Utils\ICA\Client\Requests\Bundle;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * acceptTermsOfUseBundle
 */
class AcceptTermsOfUseBundle extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/termsOfUse:accept";
	}


	/**
	 * @param string $bundleId The ID of the bundle where the terms of use are accepted of.
	 */
	public function __construct(
		protected string $bundleId,
	) {
	}
}
