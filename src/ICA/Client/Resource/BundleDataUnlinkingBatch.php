<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\BundleDataUnlinkingBatch\CreateBundleDataUnlinkingBatch;
use MLL\Utils\ICA\Client\Requests\BundleDataUnlinkingBatch\GetBundleDataUnlinkingBatch;
use MLL\Utils\ICA\Client\Requests\BundleDataUnlinkingBatch\GetBundleDataUnlinkingBatchItem;
use MLL\Utils\ICA\Client\Requests\BundleDataUnlinkingBatch\GetBundleDataUnlinkingBatchItems;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class BundleDataUnlinkingBatch extends Resource
{
	/**
	 * @param string $bundleId
	 */
	public function createBundleDataUnlinkingBatch(string $bundleId): Response
	{
		return $this->connector->send(new CreateBundleDataUnlinkingBatch($bundleId));
	}


	/**
	 * @param string $bundleId
	 * @param string $batchId
	 */
	public function getBundleDataUnlinkingBatch(string $bundleId, string $batchId): Response
	{
		return $this->connector->send(new GetBundleDataUnlinkingBatch($bundleId, $batchId));
	}


	/**
	 * @param string $bundleId
	 * @param string $batchId
	 * @param array $status The statuses to filter on.
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
	 */
	public function getBundleDataUnlinkingBatchItems(
		string $bundleId,
		string $batchId,
		?array $status,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetBundleDataUnlinkingBatchItems($bundleId, $batchId, $status, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $bundleId
	 * @param string $batchId
	 * @param string $itemId
	 */
	public function getBundleDataUnlinkingBatchItem(string $bundleId, string $batchId, string $itemId): Response
	{
		return $this->connector->send(new GetBundleDataUnlinkingBatchItem($bundleId, $batchId, $itemId));
	}
}
