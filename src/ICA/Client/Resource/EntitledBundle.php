<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\EntitledBundle\AcceptTermsOfUseEntitledBundle;
use MLL\Utils\ICA\Client\Requests\EntitledBundle\GetEntitledBundle;
use MLL\Utils\ICA\Client\Requests\EntitledBundle\GetEntitledBundleTermsOfUse;
use MLL\Utils\ICA\Client\Requests\EntitledBundle\GetEntitledBundleTermsOfUseAcceptance;
use MLL\Utils\ICA\Client\Requests\EntitledBundle\GetEntitledBundles;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class EntitledBundle extends Resource
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
	public function getEntitledBundles(
		?string $search,
		?string $userTags,
		?string $technicalTags,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetEntitledBundles($search, $userTags, $technicalTags, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $entitledBundleId The ID of the entitled bundle to retrieve
	 */
	public function getEntitledBundle(string $entitledBundleId): Response
	{
		return $this->connector->send(new GetEntitledBundle($entitledBundleId));
	}


	/**
	 * @param string $entitledBundleId The ID of the entitled bundle where the terms of use are accepted of.
	 */
	public function acceptTermsOfUseEntitledBundle(string $entitledBundleId): Response
	{
		return $this->connector->send(new AcceptTermsOfUseEntitledBundle($entitledBundleId));
	}


	/**
	 * @param string $entitledBundleId The ID of the entitled bundle of the terms of use to retrieve
	 */
	public function getEntitledBundleTermsOfUse(string $entitledBundleId): Response
	{
		return $this->connector->send(new GetEntitledBundleTermsOfUse($entitledBundleId));
	}


	/**
	 * @param string $entitledBundleId The ID of the entitled bundle of the terms of use acceptance records.
	 */
	public function getEntitledBundleTermsOfUseAcceptance(string $entitledBundleId): Response
	{
		return $this->connector->send(new GetEntitledBundleTermsOfUseAcceptance($entitledBundleId));
	}
}
