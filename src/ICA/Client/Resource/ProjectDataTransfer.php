<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectDataTransfer\AbortDataTransfer;
use MLL\Utils\ICA\Client\Requests\ProjectDataTransfer\GetDataTransfer;
use MLL\Utils\ICA\Client\Requests\ProjectDataTransfer\GetDataTransfers;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectDataTransfer extends Resource
{
	/**
	 * @param string $projectId
	 * @param string $connector The ID of the connector to filter on.
	 * @param string $direction The direction to filter on.
	 * @param string $status The status to filter on.
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
	 *
	 * The attributes for which sorting is supported:
	 * - reference
	 * - direction
	 * - connector
	 * - protocol
	 * - dataTransferred
	 * - status
	 * - statusMessage
	 * - duration
	 */
	public function getDataTransfers(
		string $projectId,
		?string $connector,
		?string $direction,
		?string $status,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetDataTransfers($projectId, $connector, $direction, $status, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $projectId
	 * @param string $dataTransferId
	 */
	public function getDataTransfer(string $projectId, string $dataTransferId): Response
	{
		return $this->connector->send(new GetDataTransfer($projectId, $dataTransferId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataTransferId
	 */
	public function abortDataTransfer(string $projectId, string $dataTransferId): Response
	{
		return $this->connector->send(new AbortDataTransfer($projectId, $dataTransferId));
	}
}
