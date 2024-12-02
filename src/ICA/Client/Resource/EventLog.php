<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\EventLog\GetEventLogs;
use MLL\Utils\ICA\Client\Requests\EventLog\SearchEventLogs;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class EventLog extends Resource
{
	/**
	 * @param string $code Code
	 * @param string $codeFilterType Code filter type
	 * @param string $category Category
	 * @param string $dateFrom Date from. Format: yyyy-MM-dd'T'HH:mm:ss.SSS'Z' eg: 2017-01-10T10:47:56.039Z
	 * @param string $dateUntil Date until. Format: yyyy-MM-dd'T'HH:mm:ss.SSS'Z' eg: 2017-01-10T10:47:56.039Z
	 * @param int $rows Amount of rows to fetch (chronologically oldest first). Maximum 250. Defaults to 250
	 */
	public function getEventLogs(
		?string $code,
		?string $codeFilterType,
		?string $category,
		?string $dateFrom,
		?string $dateUntil,
		?int $rows,
	): Response
	{
		return $this->connector->send(new GetEventLogs($code, $codeFilterType, $category, $dateFrom, $dateUntil, $rows));
	}


	/**
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
	 *
	 * The attributes for which sorting is supported:
	 * - timeCreated
	 */
	public function searchEventLogs(?string $pageOffset, ?string $pageToken, ?string $pageSize, ?string $sort): Response
	{
		return $this->connector->send(new SearchEventLogs($pageOffset, $pageToken, $pageSize, $sort));
	}
}
