<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\BundleSample\GetBundleSamples;
use MLL\Utils\ICA\Client\Requests\BundleSample\LinkSampleToBundle;
use MLL\Utils\ICA\Client\Requests\BundleSample\UnlinkSampleFromBundle;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class BundleSample extends Resource
{
	/**
	 * @param string $bundleId The ID of the bundle to get bundle samples from
	 * @param string $search To search through multiple fields of data.
	 * @param string $userTags The user tags to filter on.
	 * @param string $technicalTags The technical tags to filter on.
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
	 * The attributes for which sorting is supported:
	 * - timeCreated
	 * - timeModified
	 * - name
	 * - description
	 * - metadataValid
	 * - status
	 */
	public function getBundleSamples(
		string $bundleId,
		?string $search,
		?string $userTags,
		?string $technicalTags,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetBundleSamples($bundleId, $search, $userTags, $technicalTags, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $bundleId
	 * @param string $sampleId
	 */
	public function linkSampleToBundle(string $bundleId, string $sampleId): Response
	{
		return $this->connector->send(new LinkSampleToBundle($bundleId, $sampleId));
	}


	/**
	 * @param string $bundleId
	 * @param string $sampleId
	 */
	public function unlinkSampleFromBundle(string $bundleId, string $sampleId): Response
	{
		return $this->connector->send(new UnlinkSampleFromBundle($bundleId, $sampleId));
	}
}
