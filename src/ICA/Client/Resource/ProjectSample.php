<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectSample\AddMetadataModelToSample;
use MLL\Utils\ICA\Client\Requests\ProjectSample\CompleteProjectSample;
use MLL\Utils\ICA\Client\Requests\ProjectSample\CreateSampleInProject;
use MLL\Utils\ICA\Client\Requests\ProjectSample\DeepDeleteSample;
use MLL\Utils\ICA\Client\Requests\ProjectSample\DeleteAndUnlinkSample;
use MLL\Utils\ICA\Client\Requests\ProjectSample\DeleteSampleWithInput;
use MLL\Utils\ICA\Client\Requests\ProjectSample\GetProjectSample;
use MLL\Utils\ICA\Client\Requests\ProjectSample\GetProjectSampleAnalyses;
use MLL\Utils\ICA\Client\Requests\ProjectSample\GetProjectSamples;
use MLL\Utils\ICA\Client\Requests\ProjectSample\GetProjectsForSample;
use MLL\Utils\ICA\Client\Requests\ProjectSample\GetSampleDataList;
use MLL\Utils\ICA\Client\Requests\ProjectSample\GetSampleHistory;
use MLL\Utils\ICA\Client\Requests\ProjectSample\GetSampleMetadataField;
use MLL\Utils\ICA\Client\Requests\ProjectSample\GetSampleMetadataFieldCount;
use MLL\Utils\ICA\Client\Requests\ProjectSample\LinkDataToSample;
use MLL\Utils\ICA\Client\Requests\ProjectSample\LinkSampleToProject;
use MLL\Utils\ICA\Client\Requests\ProjectSample\MarkSampleDeleted;
use MLL\Utils\ICA\Client\Requests\ProjectSample\SearchProjectSampleAnalyses;
use MLL\Utils\ICA\Client\Requests\ProjectSample\UnlinkDataFromSample;
use MLL\Utils\ICA\Client\Requests\ProjectSample\UnlinkSampleFromProject;
use MLL\Utils\ICA\Client\Requests\ProjectSample\UpdateProjectSample;
use MLL\Utils\ICA\Client\Requests\ProjectSample\UpdateSampleMetadataFields;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectSample extends Resource
{
	/**
	 * @param string $projectId
	 */
	public function createSampleInProject(string $projectId): Response
	{
		return $this->connector->send(new CreateSampleInProject($projectId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 */
	public function getProjectSample(string $projectId, string $sampleId): Response
	{
		return $this->connector->send(new GetProjectSample($projectId, $sampleId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId
	 */
	public function updateProjectSample(string $projectId, string $sampleId): Response
	{
		return $this->connector->send(new UpdateProjectSample($projectId, $sampleId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId
	 */
	public function linkSampleToProject(string $projectId, string $sampleId): Response
	{
		return $this->connector->send(new LinkSampleToProject($projectId, $sampleId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 */
	public function getSampleHistory(string $projectId, string $sampleId): Response
	{
		return $this->connector->send(new GetSampleHistory($projectId, $sampleId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId
	 */
	public function completeProjectSample(string $projectId, string $sampleId): Response
	{
		return $this->connector->send(new CompleteProjectSample($projectId, $sampleId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId
	 */
	public function unlinkSampleFromProject(string $projectId, string $sampleId): Response
	{
		return $this->connector->send(new UnlinkSampleFromProject($projectId, $sampleId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 */
	public function getProjectsForSample(string $projectId, string $sampleId): Response
	{
		return $this->connector->send(new GetProjectsForSample($projectId, $sampleId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
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
	public function getProjectSampleAnalyses(
		string $projectId,
		string $sampleId,
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
		return $this->connector->send(new GetProjectSampleAnalyses($projectId, $sampleId, $reference, $userreference, $status, $usertag, $technicaltag, $referencetag, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
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
	public function searchProjectSampleAnalyses(
		string $projectId,
		string $sampleId,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new SearchProjectSampleAnalyses($projectId, $sampleId, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample to retrieve data for
	 * @param string $fullText To search through multiple fields of data.
	 * @param array $id The ids to filter on. This will always match exact.
	 * @param array $filename The filenames to filter on. The filenameMatchMode-parameter determines how the filtering is done.
	 * @param string $filenameMatchMode How the filenames are filtered.
	 * @param array $filePath The paths of the files to filter on.
	 * @param string $filePathMatchMode How the file paths are filtered:
	 *  - STARTS_WITH_CASE_INSENSITIVE: Filters the file path to start with the value of the 'filePath' parameter, regardless of upper/lower casing. This allows e.g. listing all data in a folder and all it's sub-folders (recursively).
	 *  - FULL_CASE_INSENSITIVE: Filters the file path to fully match the value of the 'filePath' parameter, regardless of upper/lower casing. Note that this can result in multiple results if e.g. two files exist with the same filename but different casing (abc.txt and ABC.txt).
	 * @param array $status The statuses to filter on.
	 * @param array $formatId The IDs of the formats to filter on.
	 * @param array $formatCode The codes of the formats to filter on.
	 * @param string $type The type to filter on.
	 * @param array $parentFolderId The IDs of parents folders to filter on. Lists all files and folders within the folder for the given ID, non-recursively.
	 * @param string $parentFolderPath The full path of the parent folder. Should start and end with a '/'. Lists all files and folders within the folder for the given path, non-recursively. This can be used to browse through the hierarchical tree of folders, e.g. traversing one level up can be done by removing the last part of the path.
	 * @param string $creationDateAfter The date after which the data is created. Format: yyyy-MM-dd'T'HH:mm:ss'Z' eg: 2021-01-30T08:30:00Z
	 * @param string $creationDateBefore The date before which the data is created. Format: yyyy-MM-dd'T'HH:mm:ss'Z' eg: 2021-01-30T08:30:00Z
	 * @param string $statusDateAfter The date after which the status has been updated. Format: yyyy-MM-dd'T'HH:mm:ss'Z' eg: 2021-01-30T08:30:00Z
	 * @param string $statusDateBefore The date before which the status has been updated. Format: yyyy-MM-dd'T'HH:mm:ss'Z' eg: 2021-01-30T08:30:00Z
	 * @param array $userTag The usertags to filter on. The userTagMatchMode-parameter determines how the filtering is done.
	 * @param string $userTagMatchMode How the usertags are filtered.
	 * @param array $runInputTag The runInputTags to filter on. The runInputTagMatchMode-parameter determines how the filtering is done.
	 * @param string $runInputTagMatchMode How the runInputTags are filtered.
	 * @param array $runOutputTag The runOutputTags to filter on. The runOutputTagMatchMode-parameter determines how the filtering is done.
	 * @param string $runOutputTagMatchMode How the runOutputTags are filtered.
	 * @param array $connectorTag The connectorTags to filter on. The connectorTagMatchMode-parameter determines how the filtering is done.
	 * @param string $connectorTagMatchMode How the connectorTags are filtered.
	 * @param array $technicalTag The technicalTags to filter on. The techTagMatchMode-parameter determines how the filtering is done.
	 * @param string $technicalTagMatchMode How the technicalTags are filtered.
	 * @param bool $notInRun When set to true, the data will be filtered on data which is not used in a run.
	 * @param array $instrumentRunId The instrument run IDs of the sequencing runs to filter on.
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
	 *
	 * The attributes for which sorting is supported:
	 * - timeCreated
	 * - timeModified
	 * - name
	 * - path
	 * - fileSizeInBytes
	 * - status
	 * - format
	 * - dataType
	 * - willBeArchivedAt
	 * - willBeDeletedAt
	 */
	public function getSampleDataList(
		string $projectId,
		string $sampleId,
		?string $fullText,
		?array $id,
		?array $filename,
		?string $filenameMatchMode,
		?array $filePath,
		?string $filePathMatchMode,
		?array $status,
		?array $formatId,
		?array $formatCode,
		?string $type,
		?array $parentFolderId,
		?string $parentFolderPath,
		?string $creationDateAfter,
		?string $creationDateBefore,
		?string $statusDateAfter,
		?string $statusDateBefore,
		?array $userTag,
		?string $userTagMatchMode,
		?array $runInputTag,
		?string $runInputTagMatchMode,
		?array $runOutputTag,
		?string $runOutputTagMatchMode,
		?array $connectorTag,
		?string $connectorTagMatchMode,
		?array $technicalTag,
		?string $technicalTagMatchMode,
		?bool $notInRun,
		?array $instrumentRunId,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetSampleDataList($projectId, $sampleId, $fullText, $id, $filename, $filenameMatchMode, $filePath, $filePathMatchMode, $status, $formatId, $formatCode, $type, $parentFolderId, $parentFolderPath, $creationDateAfter, $creationDateBefore, $statusDateAfter, $statusDateBefore, $userTag, $userTagMatchMode, $runInputTag, $runInputTagMatchMode, $runOutputTag, $runOutputTagMatchMode, $connectorTag, $connectorTagMatchMode, $technicalTag, $technicalTagMatchMode, $notInRun, $instrumentRunId, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 * @param string $dataId The ID of the data to link
	 */
	public function linkDataToSample(string $projectId, string $sampleId, string $dataId): Response
	{
		return $this->connector->send(new LinkDataToSample($projectId, $sampleId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 * @param string $dataId The ID of the data to unlink
	 */
	public function unlinkDataFromSample(string $projectId, string $sampleId, string $dataId): Response
	{
		return $this->connector->send(new UnlinkDataFromSample($projectId, $sampleId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 */
	public function deepDeleteSample(string $projectId, string $sampleId): Response
	{
		return $this->connector->send(new DeepDeleteSample($projectId, $sampleId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 */
	public function deleteSampleWithInput(string $projectId, string $sampleId): Response
	{
		return $this->connector->send(new DeleteSampleWithInput($projectId, $sampleId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 */
	public function markSampleDeleted(string $projectId, string $sampleId): Response
	{
		return $this->connector->send(new MarkSampleDeleted($projectId, $sampleId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 */
	public function deleteAndUnlinkSample(string $projectId, string $sampleId): Response
	{
		return $this->connector->send(new DeleteAndUnlinkSample($projectId, $sampleId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 * @param string $metadataModelId The ID of the metadata model
	 */
	public function addMetadataModelToSample(string $projectId, string $sampleId, string $metadataModelId): Response
	{
		return $this->connector->send(new AddMetadataModelToSample($projectId, $sampleId, $metadataModelId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId
	 */
	public function updateSampleMetadataFields(string $projectId, string $sampleId): Response
	{
		return $this->connector->send(new UpdateSampleMetadataFields($projectId, $sampleId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 * @param string $fieldId The ID of the field
	 */
	public function getSampleMetadataField(string $projectId, string $sampleId, string $fieldId): Response
	{
		return $this->connector->send(new GetSampleMetadataField($projectId, $sampleId, $fieldId));
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 * @param string $fieldId The ID of the field
	 */
	public function getSampleMetadataFieldCount(string $projectId, string $sampleId, string $fieldId): Response
	{
		return $this->connector->send(new GetSampleMetadataFieldCount($projectId, $sampleId, $fieldId));
	}


	/**
	 * @param string $projectId
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
	 * The attributes for which sorting is supported:
	 * - timeCreated
	 * - timeModified
	 * - name
	 * - description
	 * - metadataValid
	 * - status
	 */
	public function getProjectSamples(
		string $projectId,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetProjectSamples($projectId, $pageOffset, $pageToken, $pageSize, $sort));
	}
}
