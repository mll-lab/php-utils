<?php

namespace MLL\Utils\ICA\Client\Requests\BundleDataLinkingBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBundleDataLinkingBatch
 */
class GetBundleDataLinkingBatch extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/dataLinkingBatch/{$this->batchId}";
	}


	/**
	 * @param string $bundleId
	 * @param string $batchId
	 */
	public function __construct(
		protected string $bundleId,
		protected string $batchId,
	) {
	}
}
