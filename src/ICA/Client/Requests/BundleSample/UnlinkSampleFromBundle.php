<?php

namespace MLL\Utils\ICA\Client\Requests\BundleSample;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * unlinkSampleFromBundle
 */
class UnlinkSampleFromBundle extends Request
{
	protected Method $method = Method::DELETE;


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
