<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectAnalysis;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getAnalyses
 *
 * This endpoint only returns V3 items. Use the search endpoint to get V4 items.
 */
class GetAnalyses extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/analyses";
	}


	/**
	 * @param string $projectId
	 * @param null|string $reference The reference to filter on.
	 * @param null|string $userreference The user-reference to filter on.
	 * @param null|string $status The status to filter on.
	 * @param null|string $usertag The user-tags to filter on.
	 * @param null|string $technicaltag The technical-tags to filter on.
	 * @param null|string $referencetag The reference-data-tags to filter on.
	 * @param null|string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param null|string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param null|string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param null|string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
	 *
	 * The attributes for which sorting is supported:
	 * - reference
	 * - userReference
	 * - pipeline
	 * - status
	 * - startDate
	 * - endDate
	 * - summary
	 */
	public function __construct(
		protected string $projectId,
		protected ?string $reference = null,
		protected ?string $userreference = null,
		protected ?string $status = null,
		protected ?string $usertag = null,
		protected ?string $technicaltag = null,
		protected ?string $referencetag = null,
		protected ?string $pageOffset = null,
		protected ?string $pageToken = null,
		protected ?string $pageSize = null,
		protected ?string $sort = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter([
			'reference' => $this->reference,
			'userreference' => $this->userreference,
			'status' => $this->status,
			'usertag' => $this->usertag,
			'technicaltag' => $this->technicaltag,
			'referencetag' => $this->referencetag,
			'pageOffset' => $this->pageOffset,
			'pageToken' => $this->pageToken,
			'pageSize' => $this->pageSize,
			'sort' => $this->sort,
		]);
	}
}
