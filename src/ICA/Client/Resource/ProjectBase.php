<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectBase\CreateBaseConnectionDetails;
use MLL\Utils\ICA\Client\Requests\ProjectBase\GetBaseJob;
use MLL\Utils\ICA\Client\Requests\ProjectBase\GetBaseJobs;
use MLL\Utils\ICA\Client\Requests\ProjectBase\GetBaseTables;
use MLL\Utils\ICA\Client\Requests\ProjectBase\LoadData;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectBase extends Resource
{
	/**
	 * @param string $projectId
	 */
	public function createBaseConnectionDetails(string $projectId): Response
	{
		return $this->connector->send(new CreateBaseConnectionDetails($projectId));
	}


	/**
	 * @param string $projectId
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
	 *
	 * The attributes for which sorting is supported:
	 * - description
	 * - type
	 */
	public function getBaseJobs(
		string $projectId,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetBaseJobs($projectId, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $projectId
	 * @param string $baseJobId
	 */
	public function getBaseJob(string $projectId, string $baseJobId): Response
	{
		return $this->connector->send(new GetBaseJob($projectId, $baseJobId));
	}


	/**
	 * @param string $projectId
	 */
	public function getBaseTables(string $projectId): Response
	{
		return $this->connector->send(new GetBaseTables($projectId));
	}


	/**
	 * @param string $projectId
	 * @param string $tableId
	 */
	public function loadData(string $projectId, string $tableId): Response
	{
		return $this->connector->send(new LoadData($projectId, $tableId));
	}
}
