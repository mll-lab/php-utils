<?php

namespace MLL\Utils\ICA\Client\Requests\BundleTool;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * unlinkToolFromBundle
 */
class UnlinkToolFromBundle extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/tools/{$this->toolId}";
	}


	/**
	 * @param string $bundleId
	 * @param string $toolId
	 */
	public function __construct(
		protected string $bundleId,
		protected string $toolId,
	) {
	}
}
