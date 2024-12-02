<?php

namespace MLL\Utils\ICA\Client\Requests\EntitledBundle;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getEntitledBundleTermsOfUseAcceptance
 */
class GetEntitledBundleTermsOfUseAcceptance extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/entitledbundles/{$this->entitledBundleId}/termsOfUse/userAcceptance/currentUser";
	}


	/**
	 * @param string $entitledBundleId The ID of the entitled bundle of the terms of use acceptance records.
	 */
	public function __construct(
		protected string $entitledBundleId,
	) {
	}
}
