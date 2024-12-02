<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\BundleData\GetBundleData;
use MLL\Utils\ICA\Client\Requests\BundleData\LinkDataToBundle;
use MLL\Utils\ICA\Client\Requests\BundleData\UnlinkDataFromBundle;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class BundleData extends Resource
{
	/**
	 * @param string $bundleId
	 * @param string $fullText To search through multiple fields of data.
	 * @param string $id The ids to filter on. This will always match exact.
	 * @param string $filename The filenames to filter on. The filenameMatchMode-parameter determines how the filtering is done.
	 * @param string $filenameMatchMode How the filenames are filtered.
	 * @param string $filePath The paths of the files to filter on.
	 * @param string $filePathMatchMode How the file paths are filtered:
	 *  - STARTS_WITH_CASE_INSENSITIVE: Filters the file path to start with the value of the 'filePath' parameter, regardless of upper/lower casing. This allows e.g. listing all data in a folder and all it's sub-folders (recursively).
	 *  - FULL_CASE_INSENSITIVE: Filters the file path to fully match the value of the 'filePath' parameter, regardless of upper/lower casing. Note that this can result in multiple results if e.g. two files exist with the same filename but different casing (abc.txt and ABC.txt).
	 * @param string $status The statuses to filter on.
	 * @param string $formatId The IDs of the formats to filter on.
	 * @param string $formatCode The codes of the formats to filter on.
	 * @param string $type The type to filter on.
	 * @param string $parentFolderId The IDs of parents folders to filter on. Lists all files and folders within the folder for the given ID, non-recursively.
	 * @param string $parentFolderPath The full path of the parent folder. Should start and end with a '/'. Lists all files and folders within the folder for the given path, non-recursively. This can be used to browse through the hierarchical tree of folders, e.g. traversing one level up can be done by removing the last part of the path.
	 * @param string $creationDateAfter The date after which the data is created. Format: yyyy-MM-dd'T'HH:mm:ss'Z' eg: 2021-01-30T08:30:00Z
	 * @param string $creationDateBefore The date before which the data is created. Format: yyyy-MM-dd'T'HH:mm:ss'Z' eg: 2021-01-30T08:30:00Z
	 * @param string $statusDateAfter The date after which the status has been updated. Format: yyyy-MM-dd'T'HH:mm:ss'Z' eg: 2021-01-30T08:30:00Z
	 * @param string $statusDateBefore The date before which the status has been updated Format: yyyy-MM-dd'T'HH:mm:ss'Z' eg: 2021-01-30T08:30:00Z
	 * @param string $userTag The usertags to filter on. The userTagMatchMode-parameter determines how the filtering is done.
	 * @param string $userTagMatchMode How the usertags are filtered.
	 * @param string $runInputTag The runInputTags to filter on. The runInputTagMatchMode-parameter determines how the filtering is done.
	 * @param string $runInputTagMatchMode How the runInputTags are filtered.
	 * @param string $runOutputTag The runOutputTags to filter on. The runOutputTagMatchMode-parameter determines how the filtering is done.
	 * @param string $runOutputTagMatchMode How the runOutputTags are filtered.
	 * @param string $connectorTag The connectorTags to filter on. The connectorTagMatchMode-parameter determines how the filtering is done.
	 * @param string $connectorTagMatchMode How the connectorTags are filtered.
	 * @param string $technicalTag The technicalTags to filter on. The techTagMatchMode-parameter determines how the filtering is done.
	 * @param string $technicalTagMatchMode How the technicalTags are filtered.
	 * @param string $notInRun When set to true, the data will be filtered on data which is not used in a run.
	 * @param string $notLinkedToSample When set to true only date that is unlinked to a sample will be returned.  This filter implies a filter of type File.
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
	public function getBundleData(
		string $bundleId,
		?string $fullText,
		?string $id,
		?string $filename,
		?string $filenameMatchMode,
		?string $filePath,
		?string $filePathMatchMode,
		?string $status,
		?string $formatId,
		?string $formatCode,
		?string $type,
		?string $parentFolderId,
		?string $parentFolderPath,
		?string $creationDateAfter,
		?string $creationDateBefore,
		?string $statusDateAfter,
		?string $statusDateBefore,
		?string $userTag,
		?string $userTagMatchMode,
		?string $runInputTag,
		?string $runInputTagMatchMode,
		?string $runOutputTag,
		?string $runOutputTagMatchMode,
		?string $connectorTag,
		?string $connectorTagMatchMode,
		?string $technicalTag,
		?string $technicalTagMatchMode,
		?string $notInRun,
		?string $notLinkedToSample,
		?array $instrumentRunId,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetBundleData($bundleId, $fullText, $id, $filename, $filenameMatchMode, $filePath, $filePathMatchMode, $status, $formatId, $formatCode, $type, $parentFolderId, $parentFolderPath, $creationDateAfter, $creationDateBefore, $statusDateAfter, $statusDateBefore, $userTag, $userTagMatchMode, $runInputTag, $runInputTagMatchMode, $runOutputTag, $runOutputTagMatchMode, $connectorTag, $connectorTagMatchMode, $technicalTag, $technicalTagMatchMode, $notInRun, $notLinkedToSample, $instrumentRunId, $pageOffset, $pageToken, $pageSize, $sort));
	}


	/**
	 * @param string $bundleId
	 * @param string $dataId
	 */
	public function linkDataToBundle(string $bundleId, string $dataId): Response
	{
		return $this->connector->send(new LinkDataToBundle($bundleId, $dataId));
	}


	/**
	 * @param string $bundleId
	 * @param string $dataId
	 */
	public function unlinkDataFromBundle(string $bundleId, string $dataId): Response
	{
		return $this->connector->send(new UnlinkDataFromBundle($bundleId, $dataId));
	}
}
