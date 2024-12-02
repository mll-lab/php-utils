<?php

namespace MLL\Utils\ICA\Client\Requests\BundleSample;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * linkSampleToBundle
 */
class LinkSampleToBundle extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/samples/{$this->sampleId}";
	}


	/**
	 * @param string $bundleId
	 * @param string $sampleId
	 */
	public function __construct(
		protected string $bundleId,
		protected string $sampleId,
	) {
	}
}
