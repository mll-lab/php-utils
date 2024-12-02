<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectData\AddSecondaryData;
use MLL\Utils\ICA\Client\Requests\ProjectData\ArchiveData;
use MLL\Utils\ICA\Client\Requests\ProjectData\CompleteFolderUploadSession;
use MLL\Utils\ICA\Client\Requests\ProjectData\CreateDataInProject;
use MLL\Utils\ICA\Client\Requests\ProjectData\CreateDownloadUrlForData;
use MLL\Utils\ICA\Client\Requests\ProjectData\CreateDownloadUrlsForData;
use MLL\Utils\ICA\Client\Requests\ProjectData\CreateFileWithTemporaryCredentials;
use MLL\Utils\ICA\Client\Requests\ProjectData\CreateFileWithUploadUrl;
use MLL\Utils\ICA\Client\Requests\ProjectData\CreateFolderUploadSession;
use MLL\Utils\ICA\Client\Requests\ProjectData\CreateFolderWithTemporaryCredentials;
use MLL\Utils\ICA\Client\Requests\ProjectData\CreateFolderWithUploadSession;
use MLL\Utils\ICA\Client\Requests\ProjectData\CreateInlineViewUrlForData;
use MLL\Utils\ICA\Client\Requests\ProjectData\CreateTemporaryCredentialsForData;
use MLL\Utils\ICA\Client\Requests\ProjectData\CreateUploadUrlForData;
use MLL\Utils\ICA\Client\Requests\ProjectData\DeleteData;
use MLL\Utils\ICA\Client\Requests\ProjectData\GetDataEligibleForLinking;
use MLL\Utils\ICA\Client\Requests\ProjectData\GetFolderUploadSession;
use MLL\Utils\ICA\Client\Requests\ProjectData\GetNonSampleProjectData;
use MLL\Utils\ICA\Client\Requests\ProjectData\GetProjectData;
use MLL\Utils\ICA\Client\Requests\ProjectData\GetProjectDataChildren;
use MLL\Utils\ICA\Client\Requests\ProjectData\GetProjectDataList;
use MLL\Utils\ICA\Client\Requests\ProjectData\GetProjectsLinkedToData;
use MLL\Utils\ICA\Client\Requests\ProjectData\GetSecondaryData;
use MLL\Utils\ICA\Client\Requests\ProjectData\LinkDataToProject;
use MLL\Utils\ICA\Client\Requests\ProjectData\RemoveSecondaryData;
use MLL\Utils\ICA\Client\Requests\ProjectData\ScheduleDownloadForData;
use MLL\Utils\ICA\Client\Requests\ProjectData\UnarchiveData;
use MLL\Utils\ICA\Client\Requests\ProjectData\UnlinkDataFromProject;
use MLL\Utils\ICA\Client\Requests\ProjectData\UpdateProjectData;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectData extends Resource
{
	/**
	 * @param string $projectId
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
	 * @param bool $notLinkedToSample When set to true only data that is unlinked to a sample will be returned.  This filter implies a filter of type File.
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
	public function getProjectDataList(
		string $projectId,
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
		?bool $notLinkedToSample,
		?array $instrumentRunId,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetProjectDataList($projectId, $fullText, $id, $filename, $filenameMatchMode, $filePath, $filePathMatchMode, $status, $formatId, $formatCode, $type, $parentFolderId, $parentFolderPath, $creationDateAfter, $creationDateBefore, $statusDateAfter, $statusDateBefore, $userTag, $userTagMatchMode, $runInputTag, $runInputTagMatchMode, $runOutputTag, $runOutputTagMatchMode, $connectorTag, $connectorTagMatchMode, $technicalTag, $technicalTagMatchMode, $notInRun, $notLinkedToSample, $instrumentRunId, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $projectId
	 */
	public function createDataInProject(string $projectId): Response
	{
		return $this->connector->send(new CreateDataInProject($projectId));
	}


	/**
	 * @param string $projectId
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
	 * @param bool $notLinkedToSample When set to true only data that is unlinked to a sample will be returned. This filter implies a filter of type File.
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
	public function getDataEligibleForLinking(
		string $projectId,
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
		?bool $notLinkedToSample,
		?array $instrumentRunId,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetDataEligibleForLinking($projectId, $fullText, $id, $filename, $filenameMatchMode, $filePath, $filePathMatchMode, $status, $formatId, $formatCode, $type, $parentFolderId, $parentFolderPath, $creationDateAfter, $creationDateBefore, $statusDateAfter, $statusDateBefore, $userTag, $userTagMatchMode, $runInputTag, $runInputTagMatchMode, $runOutputTag, $runOutputTagMatchMode, $connectorTag, $connectorTagMatchMode, $technicalTag, $technicalTagMatchMode, $notInRun, $notLinkedToSample, $instrumentRunId, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $projectId
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 */
	public function getNonSampleProjectData(
		string $projectId,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
	): Response
	{
		return $this->connector->send(new GetNonSampleProjectData($projectId, $pageOffset, $pageToken, $pageSize));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function getProjectData(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new GetProjectData($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function updateProjectData(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new UpdateProjectData($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function linkDataToProject(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new LinkDataToProject($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 */
	public function getProjectDataChildren(
		string $projectId,
		string $dataId,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
	): Response
	{
		return $this->connector->send(new GetProjectDataChildren($projectId, $dataId, $pageOffset, $pageToken, $pageSize));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function getProjectsLinkedToData(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new GetProjectsLinkedToData($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function getSecondaryData(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new GetSecondaryData($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 * @param string $secondaryDataId
	 */
	public function addSecondaryData(string $projectId, string $dataId, string $secondaryDataId): Response
	{
		return $this->connector->send(new AddSecondaryData($projectId, $dataId, $secondaryDataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 * @param string $secondaryDataId
	 */
	public function removeSecondaryData(string $projectId, string $dataId, string $secondaryDataId): Response
	{
		return $this->connector->send(new RemoveSecondaryData($projectId, $dataId, $secondaryDataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function createInlineViewUrlForData(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new CreateInlineViewUrlForData($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function createDownloadUrlForData(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new CreateDownloadUrlForData($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 * @param string $fileType
	 * @param string $hash
	 */
	public function createUploadUrlForData(string $projectId, string $dataId, ?string $fileType, ?string $hash): Response
	{
		return $this->connector->send(new CreateUploadUrlForData($projectId, $dataId, $fileType, $hash));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function createTemporaryCredentialsForData(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new CreateTemporaryCredentialsForData($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function scheduleDownloadForData(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new ScheduleDownloadForData($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function unlinkDataFromProject(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new UnlinkDataFromProject($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function archiveData(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new ArchiveData($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function unarchiveData(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new UnarchiveData($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function deleteData(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new DeleteData($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function createFolderUploadSession(string $projectId, string $dataId): Response
	{
		return $this->connector->send(new CreateFolderUploadSession($projectId, $dataId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 * @param string $folderUploadSessionId
	 */
	public function getFolderUploadSession(string $projectId, string $dataId, string $folderUploadSessionId): Response
	{
		return $this->connector->send(new GetFolderUploadSession($projectId, $dataId, $folderUploadSessionId));
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 * @param string $folderUploadSessionId
	 */
	public function completeFolderUploadSession(
		string $projectId,
		string $dataId,
		string $folderUploadSessionId,
	): Response
	{
		return $this->connector->send(new CompleteFolderUploadSession($projectId, $dataId, $folderUploadSessionId));
	}


	/**
	 * @param string $projectId
	 */
	public function createFileWithTemporaryCredentials(string $projectId): Response
	{
		return $this->connector->send(new CreateFileWithTemporaryCredentials($projectId));
	}


	/**
	 * @param string $projectId
	 */
	public function createFileWithUploadUrl(string $projectId): Response
	{
		return $this->connector->send(new CreateFileWithUploadUrl($projectId));
	}


	/**
	 * @param string $projectId
	 */
	public function createFolderWithTemporaryCredentials(string $projectId): Response
	{
		return $this->connector->send(new CreateFolderWithTemporaryCredentials($projectId));
	}


	/**
	 * @param string $projectId
	 */
	public function createFolderWithUploadSession(string $projectId): Response
	{
		return $this->connector->send(new CreateFolderWithUploadSession($projectId));
	}


	/**
	 * @param string $projectId
	 */
	public function createDownloadUrlsForData(string $projectId): Response
	{
		return $this->connector->send(new CreateDownloadUrlsForData($projectId));
	}
}
