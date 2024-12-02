<?php

namespace MLL\Utils\ICA\Client\Requests\BundleData;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * unlinkDataFromBundle
 *
 * Note that for folders, this only unlinks the folder itself, not the folder contents!  Use 'Bundle
 * Data Unlinking Batch' for recursive unlinking.
 */
class UnlinkDataFromBundle extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/data/{$this->dataId}";
	}


	/**
	 * @param string $bundleId
	 * @param string $dataId
	 */
	public function __construct(
		protected string $bundleId,
		protected string $dataId,
	) {
	}
}
