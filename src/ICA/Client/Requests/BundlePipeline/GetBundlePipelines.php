<?php

namespace MLL\Utils\ICA\Client\Requests\BundlePipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBundlePipelines
 */
class GetBundlePipelines extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/pipelines";
	}


	/**
	 * @param string $bundleId The ID of the bundle to retrieve pipelines for
	 */
	public function __construct(
		protected string $bundleId,
	) {
	}
}
