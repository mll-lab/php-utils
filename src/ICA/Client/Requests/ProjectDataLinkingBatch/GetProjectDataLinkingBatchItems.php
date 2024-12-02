<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataLinkingBatch;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectDataLinkingBatchItems
 *
 * # Changelog
 * For this endpoint multiple versions exist. Note that the values for request headers
 * 'Content-Type' and 'Accept' must contain a matching version.
 *
 * ## [V3]
 * Initial version, deprecated,
 * returns PARTIALLY_LINKED item processing status as FAILED.
 * ## [V4]
 * Supports PARTIALLY_LINKED item
 * processing status.
 */
class GetProjectDataLinkingBatchItems extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataLinkingBatch/{$this->batchId}/items";
	}


	/**
	 * @param string $projectId
	 * @param string $batchId
	 * @param null|array $status The statuses to filter on.
	 * @param null|string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param null|string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param null|string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 */
	public function __construct(
		protected string $projectId,
		protected string $batchId,
		protected ?array $status = null,
		protected ?string $pageOffset = null,
		protected ?string $pageToken = null,
		protected ?string $pageSize = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter([
			'status' => $this->status,
			'pageOffset' => $this->pageOffset,
			'pageToken' => $this->pageToken,
			'pageSize' => $this->pageSize,
		]);
	}
}
