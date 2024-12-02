<?php

namespace MLL\Utils\ICA\Client\Requests\BundleData;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * linkDataToBundle
 */
class LinkDataToBundle extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


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
