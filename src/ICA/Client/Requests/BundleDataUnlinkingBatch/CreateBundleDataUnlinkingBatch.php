<?php

namespace MLL\Utils\ICA\Client\Requests\BundleDataUnlinkingBatch;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createBundleDataUnlinkingBatch
 */
class CreateBundleDataUnlinkingBatch extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/dataUnlinkingBatch";
	}


	/**
	 * @param string $bundleId
	 */
	public function __construct(
		protected string $bundleId,
	) {
	}
}
