<?php

namespace MLL\Utils\ICA\Client\Requests\Bundle;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getTermsOfUseAcceptance
 */
class GetTermsOfUseAcceptance extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/termsOfUse/userAcceptance/currentUser";
	}


	/**
	 * @param string $bundleId The ID of the bundle of the terms of use acceptance records.
	 */
	public function __construct(
		protected string $bundleId,
	) {
	}
}
