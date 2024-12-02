<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\Bundle\AcceptTermsOfUseBundle;
use MLL\Utils\ICA\Client\Requests\Bundle\CreateBundle;
use MLL\Utils\ICA\Client\Requests\Bundle\DeprecateBundle;
use MLL\Utils\ICA\Client\Requests\Bundle\GetBundle;
use MLL\Utils\ICA\Client\Requests\Bundle\GetBundleTermsOfUse;
use MLL\Utils\ICA\Client\Requests\Bundle\GetBundles;
use MLL\Utils\ICA\Client\Requests\Bundle\GetTermsOfUseAcceptance;
use MLL\Utils\ICA\Client\Requests\Bundle\InsertBundleTermsOfUse;
use MLL\Utils\ICA\Client\Requests\Bundle\ReleaseBundle;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class Bundle extends Resource
{
	/**
	 * @param string $search Search
	 * @param string $userTags User tags to filter on
	 * @param string $technicalTags Technical tags to filter on
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
	 *
	 * The attributes for which sorting is supported:
	 * - name
	 * - shortDescription
	 */
	public function getBundles(
		?string $search,
		?string $userTags,
		?string $technicalTags,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetBundles($search, $userTags, $technicalTags, $pageOffset, $pageToken, $pageSize, $sort));
	}


	public function createBundle(): Response
	{
		return $this->connector->send(new CreateBundle());
	}


	/**
	 * @param string $bundleId The ID of the bundle to retrieve
	 */
	public function getBundle(string $bundleId): Response
	{
		return $this->connector->send(new GetBundle($bundleId));
	}


	/**
	 * @param string $bundleId The ID of the bundle where the terms of use are accepted of.
	 */
	public function acceptTermsOfUseBundle(string $bundleId): Response
	{
		return $this->connector->send(new AcceptTermsOfUseBundle($bundleId));
	}


	/**
	 * @param string $bundleId The ID of the bundle to release
	 */
	public function releaseBundle(string $bundleId): Response
	{
		return $this->connector->send(new ReleaseBundle($bundleId));
	}


	/**
	 * @param string $bundleId The ID of the bundle of the terms of use to retrieve
	 */
	public function getBundleTermsOfUse(string $bundleId): Response
	{
		return $this->connector->send(new GetBundleTermsOfUse($bundleId));
	}


	/**
	 * @param string $bundleId The ID of the bundle of the terms of use acceptance records.
	 */
	public function getTermsOfUseAcceptance(string $bundleId): Response
	{
		return $this->connector->send(new GetTermsOfUseAcceptance($bundleId));
	}


	/**
	 * @param string $bundleId The ID of the bundle to update
	 */
	public function insertBundleTermsOfUse(string $bundleId): Response
	{
		return $this->connector->send(new InsertBundleTermsOfUse($bundleId));
	}


	/**
	 * @param string $bundleId The ID of the bundle to deprecate.
	 */
	public function deprecateBundle(string $bundleId): Response
	{
		return $this->connector->send(new DeprecateBundle($bundleId));
	}
}
