<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\AbortAnalysis;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\CreateCwlAnalysis;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\CreateNextflowAnalysis;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\CreateNextflowJsonAnalysis;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\GetAnalyses;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\GetAnalysis;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\GetAnalysisConfigurations;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\GetAnalysisInputs;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\GetAnalysisOutputs;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\GetAnalysisSteps;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\GetCwlinputJson;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\GetCwloutputJson;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\GetProjectAnalysisInputFormValues;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\GetRawAnalysisOutput;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\SearchAnalyses;
use MLL\Utils\ICA\Client\Requests\ProjectAnalysis\UpdateAnalysis;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectAnalysis extends Resource
{
	/**
	 * @param string $projectId
	 * @param string $reference The reference to filter on.
	 * @param string $userreference The user-reference to filter on.
	 * @param string $status The status to filter on.
	 * @param string $usertag The user-tags to filter on.
	 * @param string $technicaltag The technical-tags to filter on.
	 * @param string $referencetag The reference-data-tags to filter on.
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
	public function getAnalyses(
		string $projectId,
		?string $reference,
		?string $userreference,
		?string $status,
		?string $usertag,
		?string $technicaltag,
		?string $referencetag,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetAnalyses($projectId, $reference, $userreference, $status, $usertag, $technicaltag, $referencetag, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis to retrieve
	 */
	public function getAnalysis(string $projectId, string $analysisId): Response
	{
		return $this->connector->send(new GetAnalysis($projectId, $analysisId));
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId
	 */
	public function updateAnalysis(string $projectId, string $analysisId): Response
	{
		return $this->connector->send(new UpdateAnalysis($projectId, $analysisId));
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis to retrieve the individual steps for
	 */
	public function getAnalysisSteps(string $projectId, string $analysisId): Response
	{
		return $this->connector->send(new GetAnalysisSteps($projectId, $analysisId));
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis to retrieve the inputs for
	 */
	public function getAnalysisInputs(string $projectId, string $analysisId): Response
	{
		return $this->connector->send(new GetAnalysisInputs($projectId, $analysisId));
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis to retrieve the outputs for
	 */
	public function getAnalysisOutputs(string $projectId, string $analysisId): Response
	{
		return $this->connector->send(new GetAnalysisOutputs($projectId, $analysisId));
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis for which to retrieve the raw output
	 */
	public function getRawAnalysisOutput(string $projectId, string $analysisId): Response
	{
		return $this->connector->send(new GetRawAnalysisOutput($projectId, $analysisId));
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis to retrieve the configuration for
	 */
	public function getAnalysisConfigurations(string $projectId, string $analysisId): Response
	{
		return $this->connector->send(new GetAnalysisConfigurations($projectId, $analysisId));
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis to retrieve the input form values from
	 */
	public function getProjectAnalysisInputFormValues(string $projectId, string $analysisId): Response
	{
		return $this->connector->send(new GetProjectAnalysisInputFormValues($projectId, $analysisId));
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the analysis to abort
	 */
	public function abortAnalysis(string $projectId, string $analysisId): Response
	{
		return $this->connector->send(new AbortAnalysis($projectId, $analysisId));
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
	 * - summary
	 */
	public function searchAnalyses(
		string $projectId,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new SearchAnalyses($projectId, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $projectId
	 */
	public function createCwlAnalysis(string $projectId): Response
	{
		return $this->connector->send(new CreateCwlAnalysis($projectId));
	}


	/**
	 * @param string $projectId
	 */
	public function createNextflowJsonAnalysis(string $projectId): Response
	{
		return $this->connector->send(new CreateNextflowJsonAnalysis($projectId));
	}


	/**
	 * @param string $projectId
	 */
	public function createNextflowAnalysis(string $projectId): Response
	{
		return $this->connector->send(new CreateNextflowAnalysis($projectId));
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the CWL analysis for which to retrieve the input json
	 */
	public function getCwlinputJson(string $projectId, string $analysisId): Response
	{
		return $this->connector->send(new GetCwlinputJson($projectId, $analysisId));
	}


	/**
	 * @param string $projectId
	 * @param string $analysisId The ID of the CWL analysis for which to retrieve the output json
	 */
	public function getCwloutputJson(string $projectId, string $analysisId): Response
	{
		return $this->connector->send(new GetCwloutputJson($projectId, $analysisId));
	}
}
