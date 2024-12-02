<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectSampleBatch\CreateSampleCreationBatch;
use MLL\Utils\ICA\Client\Requests\ProjectSampleBatch\GetSampleCreationBatch;
use MLL\Utils\ICA\Client\Requests\ProjectSampleBatch\GetSampleCreationBatchItem;
use MLL\Utils\ICA\Client\Requests\ProjectSampleBatch\GetSampleCreationBatchItems;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectSampleBatch extends Resource
{
	/**
	 * @param string $projectId
	 */
	public function createSampleCreationBatch(string $projectId): Response
	{
		return $this->connector->send(new CreateSampleCreationBatch($projectId));
	}


	/**
	 * @param string $projectId
	 * @param string $batchId The ID of the sample creation batch
	 */
	public function getSampleCreationBatch(string $projectId, string $batchId): Response
	{
		return $this->connector->send(new GetSampleCreationBatch($projectId, $batchId));
	}


	/**
	 * @param string $projectId
	 * @param string $batchId The ID of the sample creation batch
	 * @param array $status The statuses to filter on.
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 */
	public function getSampleCreationBatchItems(
		string $projectId,
		string $batchId,
		?array $status,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
	): Response
	{
		return $this->connector->send(new GetSampleCreationBatchItems($projectId, $batchId, $status, $pageOffset, $pageToken, $pageSize));
	}


	/**
	 * @param string $projectId
	 * @param string $batchId The ID of the sample creation batch
	 * @param string $itemId The ID of the sample creation batch item
	 */
	public function getSampleCreationBatchItem(string $projectId, string $batchId, string $itemId): Response
	{
		return $this->connector->send(new GetSampleCreationBatchItem($projectId, $batchId, $itemId));
	}
}
