<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\BundleTool\GetBundleTools;
use MLL\Utils\ICA\Client\Requests\BundleTool\GetToolsEligibleForLinkingToBundle;
use MLL\Utils\ICA\Client\Requests\BundleTool\LinkToolToBundle;
use MLL\Utils\ICA\Client\Requests\BundleTool\UnlinkToolFromBundle;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class BundleTool extends Resource
{
	/**
	 * @param string $bundleId The ID of the bundle to get tools from
	 */
	public function getBundleTools(string $bundleId): Response
	{
		return $this->connector->send(new GetBundleTools($bundleId));
	}


	/**
	 * @param string $bundleId The ID of the bundle to get the eligible tools for
	 */
	public function getToolsEligibleForLinkingToBundle(string $bundleId): Response
	{
		return $this->connector->send(new GetToolsEligibleForLinkingToBundle($bundleId));
	}


	/**
	 * @param string $bundleId The ID of the bundle to link the tool to
	 * @param string $toolId The ID of the tool to link
	 */
	public function linkToolToBundle(string $bundleId, string $toolId): Response
	{
		return $this->connector->send(new LinkToolToBundle($bundleId, $toolId));
	}


	/**
	 * @param string $bundleId
	 * @param string $toolId
	 */
	public function unlinkToolFromBundle(string $bundleId, string $toolId): Response
	{
		return $this->connector->send(new UnlinkToolFromBundle($bundleId, $toolId));
	}
}
