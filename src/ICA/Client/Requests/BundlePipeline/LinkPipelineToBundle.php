<?php

namespace MLL\Utils\ICA\Client\Requests\BundlePipeline;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * linkPipelineToBundle
 */
class LinkPipelineToBundle extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/pipelines/{$this->pipelineId}";
	}


	/**
	 * @param string $bundleId The ID of the bundle
	 * @param string $pipelineId The ID of the pipeline
	 */
	public function __construct(
		protected string $bundleId,
		protected string $pipelineId,
	) {
	}
}
