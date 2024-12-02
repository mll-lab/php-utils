<?php

namespace MLL\Utils\ICA\Client\Requests\BundleTool;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * linkToolToBundle
 */
class LinkToolToBundle extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/tools/{$this->toolId}";
	}


	/**
	 * @param string $bundleId The ID of the bundle to link the tool to
	 * @param string $toolId The ID of the tool to link
	 */
	public function __construct(
		protected string $bundleId,
		protected string $toolId,
	) {
	}
}
