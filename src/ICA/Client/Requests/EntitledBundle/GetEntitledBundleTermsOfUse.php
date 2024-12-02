<?php

namespace MLL\Utils\ICA\Client\Requests\EntitledBundle;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getEntitledBundleTermsOfUse
 */
class GetEntitledBundleTermsOfUse extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/entitledbundles/{$this->entitledBundleId}/termsOfUse";
	}


	/**
	 * @param string $entitledBundleId The ID of the entitled bundle of the terms of use to retrieve
	 */
	public function __construct(
		protected string $entitledBundleId,
	) {
	}
}
