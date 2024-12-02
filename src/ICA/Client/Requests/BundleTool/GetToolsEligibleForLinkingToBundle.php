<?php

namespace MLL\Utils\ICA\Client\Requests\BundleTool;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getToolsEligibleForLinkingToBundle
 */
class GetToolsEligibleForLinkingToBundle extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/tools/eligibleForLinking";
	}


	/**
	 * @param string $bundleId The ID of the bundle to get the eligible tools for
	 */
	public function __construct(
		protected string $bundleId,
	) {
	}
}
