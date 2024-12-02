<?php

namespace MLL\Utils\ICA\Client\Requests\Sample;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getSamples
 */
class GetSamples extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/samples";
	}


	/**
	 * @param string $region The ID of the region to filter on. This parameter is required.
	 * @param null|string $search To search through multiple fields of data.
	 * @param null|string $userTags The user tags to filter on.
	 * @param null|string $technicalTags The technical tags to filter on.
	 * @param null|string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param null|string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param null|string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param null|string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
	 *
	 * The attributes for which sorting is supported:
	 * - timeCreated
	 * - timeModified
	 * - name
	 * - description
	 * - metadataValid
	 * - status
	 */
	public function __construct(
		protected string $region,
		protected ?string $search = null,
		protected ?string $userTags = null,
		protected ?string $technicalTags = null,
		protected ?string $pageOffset = null,
		protected ?string $pageToken = null,
		protected ?string $pageSize = null,
		protected ?string $sort = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter([
			'region' => $this->region,
			'search' => $this->search,
			'userTags' => $this->userTags,
			'technicalTags' => $this->technicalTags,
			'pageOffset' => $this->pageOffset,
			'pageToken' => $this->pageToken,
			'pageSize' => $this->pageSize,
			'sort' => $this->sort,
		]);
	}
}
