<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectWorkflowSession\GetWorkflowSessionConfigurations;
use MLL\Utils\ICA\Client\Requests\ProjectWorkflowSession\GetWorkflowSessionInputs;
use MLL\Utils\ICA\Client\Requests\ProjectWorkflowSession\GetWorkflowSessions;
use MLL\Utils\ICA\Client\Requests\ProjectWorkflowSession\SearchOrchestratedAnalyses;
use MLL\Utils\ICA\Client\Requests\ProjectWorkflowSession\SearchWorkflowSessions;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectWorkflowSession extends Resource
{
	/**
	 * @param string $projectId
	 * @param string $reference The reference to filter on.
	 * @param string $userreference The user-reference to filter on.
	 * @param string $status The status to filter on.
	 * @param string $usertag The user-tags to filter on.
	 * @param string $technicaltag The technical-tags to filter on.
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
	 *
	 * The attributes for which sorting is supported:
	 * - reference
	 * - userReference
	 * - pipeline
	 * - status
	 * - startDate
	 * - endDate
	 * - workflow
	 */
	public function getWorkflowSessions(
		string $projectId,
		?string $reference,
		?string $userreference,
		?string $status,
		?string $usertag,
		?string $technicaltag,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetWorkflowSessions($projectId, $reference, $userreference, $status, $usertag, $technicaltag, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $projectId
	 * @param string $workflowSessionId The ID of the workflow session to retrieve the inputs for
	 */
	public function getWorkflowSessionInputs(string $projectId, string $workflowSessionId): Response
	{
		return $this->connector->send(new GetWorkflowSessionInputs($projectId, $workflowSessionId));
	}


	/**
	 * @param string $projectId
	 * @param string $workflowSessionId The ID of the workflow session to retrieve the configuration for
	 */
	public function getWorkflowSessionConfigurations(string $projectId, string $workflowSessionId): Response
	{
		return $this->connector->send(new GetWorkflowSessionConfigurations($projectId, $workflowSessionId));
	}


	/**
	 * @param string $projectId
	 * @param string $workflowSessionId
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
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
	public function searchOrchestratedAnalyses(
		string $projectId,
		string $workflowSessionId,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new SearchOrchestratedAnalyses($projectId, $workflowSessionId, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $projectId
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
	 *
	 * The attributes for which sorting is supported:
	 * - reference
	 * - userReference
	 * - pipeline
	 * - status
	 * - startDate
	 * - endDate
	 * - workflow
	 */
	public function searchWorkflowSessions(
		string $projectId,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new SearchWorkflowSessions($projectId, $pageOffset, $pageToken, $pageSize, $sort));
	}
}
