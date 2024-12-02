<?php

namespace MLL\Utils\ICA\Client\Requests\BundleTool;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBundleTools
 */
class GetBundleTools extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/tools";
	}


	/**
	 * @param string $bundleId The ID of the bundle to get tools from
	 */
	public function __construct(
		protected string $bundleId,
	) {
	}
}
