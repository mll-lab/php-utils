<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectDataCopyBatch\CreateProjectDataCopyBatch;
use MLL\Utils\ICA\Client\Requests\ProjectDataCopyBatch\GetProjectDataCopyBatch;
use MLL\Utils\ICA\Client\Requests\ProjectDataCopyBatch\GetProjectDataCopyBatchItem;
use MLL\Utils\ICA\Client\Requests\ProjectDataCopyBatch\GetProjectDataCopyBatchItems;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectDataCopyBatch extends Resource
{
	/**
	 * @param string $projectId The ID of the project to which the data will be copied
	 */
	public function createProjectDataCopyBatch(string $projectId): Response
	{
		return $this->connector->send(new CreateProjectDataCopyBatch($projectId));
	}


	/**
	 * @param string $projectId
	 * @param string $batchId
	 */
	public function getProjectDataCopyBatch(string $projectId, string $batchId): Response
	{
		return $this->connector->send(new GetProjectDataCopyBatch($projectId, $batchId));
	}


	/**
	 * @param string $projectId
	 * @param string $batchId
	 * @param array $status The statuses to filter on.
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 */
	public function getProjectDataCopyBatchItems(
		string $projectId,
		string $batchId,
		?array $status,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
	): Response
	{
		return $this->connector->send(new GetProjectDataCopyBatchItems($projectId, $batchId, $status, $pageOffset, $pageToken, $pageSize));
	}


	/**
	 * @param string $projectId
	 * @param string $batchId
	 * @param string $itemId
	 */
	public function getProjectDataCopyBatchItem(string $projectId, string $batchId, string $itemId): Response
	{
		return $this->connector->send(new GetProjectDataCopyBatchItem($projectId, $batchId, $itemId));
	}
}
