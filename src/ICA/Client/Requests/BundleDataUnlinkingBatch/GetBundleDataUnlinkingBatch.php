<?php

namespace MLL\Utils\ICA\Client\Requests\BundleDataUnlinkingBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBundleDataUnlinkingBatch
 */
class GetBundleDataUnlinkingBatch extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/dataUnlinkingBatch/{$this->batchId}";
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
