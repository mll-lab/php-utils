<?php

namespace MLL\Utils\ICA\Client\Requests\EntitledBundle;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * acceptTermsOfUseEntitledBundle
 */
class AcceptTermsOfUseEntitledBundle extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/entitledbundles/{$this->entitledBundleId}/termsOfUse:accept";
	}


	/**
	 * @param string $entitledBundleId The ID of the entitled bundle where the terms of use are accepted of.
	 */
	public function __construct(
		protected string $entitledBundleId,
	) {
	}
}
