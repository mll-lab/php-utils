<?php

namespace MLL\Utils\ICA\Client\Requests\BundleDataLinkingBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBundleDataLinkingBatchItem
 */
class GetBundleDataLinkingBatchItem extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/dataLinkingBatch/{$this->batchId}/items/{$this->itemId}";
	}


	/**
	 * @param string $bundleId
	 * @param string $batchId
	 * @param string $itemId
	 */
	public function __construct(
		protected string $bundleId,
		protected string $batchId,
		protected string $itemId,
	) {
	}
}
