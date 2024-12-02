<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\BundlePipeline\GetBundlePipelines;
use MLL\Utils\ICA\Client\Requests\BundlePipeline\LinkPipelineToBundle;
use MLL\Utils\ICA\Client\Requests\BundlePipeline\UnlinkPipelineFromBundle;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class BundlePipeline extends Resource
{
	/**
	 * @param string $bundleId The ID of the bundle to retrieve pipelines for
	 */
	public function getBundlePipelines(string $bundleId): Response
	{
		return $this->connector->send(new GetBundlePipelines($bundleId));
	}


	/**
	 * @param string $bundleId The ID of the bundle
	 * @param string $pipelineId The ID of the pipeline
	 */
	public function linkPipelineToBundle(string $bundleId, string $pipelineId): Response
	{
		return $this->connector->send(new LinkPipelineToBundle($bundleId, $pipelineId));
	}


	/**
	 * @param string $bundleId The ID of the bundle
	 * @param string $pipelineId The ID of the pipeline
	 */
	public function unlinkPipelineFromBundle(string $bundleId, string $pipelineId): Response
	{
		return $this->connector->send(new UnlinkPipelineFromBundle($bundleId, $pipelineId));
	}
}
