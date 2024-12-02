<?php

namespace MLL\Utils\ICA\Client\Requests\BundlePipeline;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * unlinkPipelineFromBundle
 */
class UnlinkPipelineFromBundle extends Request
{
	protected Method $method = Method::DELETE;


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
