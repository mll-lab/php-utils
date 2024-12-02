<?php

namespace MLL\Utils\ICA\Client\Requests\Bundle;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * insertBundleTermsOfUse
 */
class InsertBundleTermsOfUse extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/termsOfUse:new";
	}


	/**
	 * @param string $bundleId The ID of the bundle to update
	 */
	public function __construct(
		protected string $bundleId,
	) {
	}
}
