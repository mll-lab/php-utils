<?php

namespace MLL\Utils\ICA\Client\Requests\EntitledBundle;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getEntitledBundle
 */
class GetEntitledBundle extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/entitledbundles/{$this->entitledBundleId}";
	}


	/**
	 * @param string $entitledBundleId The ID of the entitled bundle to retrieve
	 */
	public function __construct(
		protected string $entitledBundleId,
	) {
	}
}
