<?php

namespace MLL\Utils\ICA\Client\Requests\BundleData;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBundleData
 */
class GetBundleData extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/bundles/{$this->bundleId}/data";
	}


	/**
	 * @param string $bundleId
	 * @param null|string $fullText To search through multiple fields of data.
	 * @param null|string $id The ids to filter on. This will always match exact.
	 * @param null|string $filename The filenames to filter on. The filenameMatchMode-parameter determines how the filtering is done.
	 * @param null|string $filenameMatchMode How the filenames are filtered.
	 * @param null|string $filePath The paths of the files to filter on.
	 * @param null|string $filePathMatchMode How the file paths are filtered:
	 *  - STARTS_WITH_CASE_INSENSITIVE: Filters the file path to start with the value of the 'filePath' parameter, regardless of upper/lower casing. This allows e.g. listing all data in a folder and all it's sub-folders (recursively).
	 *  - FULL_CASE_INSENSITIVE: Filters the file path to fully match the value of the 'filePath' parameter, regardless of upper/lower casing. Note that this can result in multiple results if e.g. two files exist with the same filename but different casing (abc.txt and ABC.txt).
	 * @param null|string $status The statuses to filter on.
	 * @param null|string $formatId The IDs of the formats to filter on.
	 * @param null|string $formatCode The codes of the formats to filter on.
	 * @param null|string $type The type to filter on.
	 * @param null|string $parentFolderId The IDs of parents folders to filter on. Lists all files and folders within the folder for the given ID, non-recursively.
	 * @param null|string $parentFolderPath The full path of the parent folder. Should start and end with a '/'. Lists all files and folders within the folder for the given path, non-recursively. This can be used to browse through the hierarchical tree of folders, e.g. traversing one level up can be done by removing the last part of the path.
	 * @param null|string $creationDateAfter The date after which the data is created. Format: yyyy-MM-dd'T'HH:mm:ss'Z' eg: 2021-01-30T08:30:00Z
	 * @param null|string $creationDateBefore The date before which the data is created. Format: yyyy-MM-dd'T'HH:mm:ss'Z' eg: 2021-01-30T08:30:00Z
	 * @param null|string $statusDateAfter The date after which the status has been updated. Format: yyyy-MM-dd'T'HH:mm:ss'Z' eg: 2021-01-30T08:30:00Z
	 * @param null|string $statusDateBefore The date before which the status has been updated Format: yyyy-MM-dd'T'HH:mm:ss'Z' eg: 2021-01-30T08:30:00Z
	 * @param null|string $userTag The usertags to filter on. The userTagMatchMode-parameter determines how the filtering is done.
	 * @param null|string $userTagMatchMode How the usertags are filtered.
	 * @param null|string $runInputTag The runInputTags to filter on. The runInputTagMatchMode-parameter determines how the filtering is done.
	 * @param null|string $runInputTagMatchMode How the runInputTags are filtered.
	 * @param null|string $runOutputTag The runOutputTags to filter on. The runOutputTagMatchMode-parameter determines how the filtering is done.
	 * @param null|string $runOutputTagMatchMode How the runOutputTags are filtered.
	 * @param null|string $connectorTag The connectorTags to filter on. The connectorTagMatchMode-parameter determines how the filtering is done.
	 * @param null|string $connectorTagMatchMode How the connectorTags are filtered.
	 * @param null|string $technicalTag The technicalTags to filter on. The techTagMatchMode-parameter determines how the filtering is done.
	 * @param null|string $technicalTagMatchMode How the technicalTags are filtered.
	 * @param null|string $notInRun When set to true, the data will be filtered on data which is not used in a run.
	 * @param null|string $notLinkedToSample When set to true only date that is unlinked to a sample will be returned.  This filter implies a filter of type File.
	 * @param null|array $instrumentRunId The instrument run IDs of the sequencing runs to filter on.
	 * @param null|string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param null|string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param null|string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param null|string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
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
	public function __construct(
		protected string $bundleId,
		protected ?string $fullText = null,
		protected ?string $id = null,
		protected ?string $filename = null,
		protected ?string $filenameMatchMode = null,
		protected ?string $filePath = null,
		protected ?string $filePathMatchMode = null,
		protected ?string $status = null,
		protected ?string $formatId = null,
		protected ?string $formatCode = null,
		protected ?string $type = null,
		protected ?string $parentFolderId = null,
		protected ?string $parentFolderPath = null,
		protected ?string $creationDateAfter = null,
		protected ?string $creationDateBefore = null,
		protected ?string $statusDateAfter = null,
		protected ?string $statusDateBefore = null,
		protected ?string $userTag = null,
		protected ?string $userTagMatchMode = null,
		protected ?string $runInputTag = null,
		protected ?string $runInputTagMatchMode = null,
		protected ?string $runOutputTag = null,
		protected ?string $runOutputTagMatchMode = null,
		protected ?string $connectorTag = null,
		protected ?string $connectorTagMatchMode = null,
		protected ?string $technicalTag = null,
		protected ?string $technicalTagMatchMode = null,
		protected ?string $notInRun = null,
		protected ?string $notLinkedToSample = null,
		protected ?array $instrumentRunId = null,
		protected ?string $pageOffset = null,
		protected ?string $pageToken = null,
		protected ?string $pageSize = null,
		protected ?string $sort = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter([
			'fullText' => $this->fullText,
			'id' => $this->id,
			'filename' => $this->filename,
			'filenameMatchMode' => $this->filenameMatchMode,
			'filePath' => $this->filePath,
			'filePathMatchMode' => $this->filePathMatchMode,
			'status' => $this->status,
			'formatId' => $this->formatId,
			'formatCode' => $this->formatCode,
			'type' => $this->type,
			'parentFolderId' => $this->parentFolderId,
			'parentFolderPath' => $this->parentFolderPath,
			'creationDateAfter' => $this->creationDateAfter,
			'creationDateBefore' => $this->creationDateBefore,
			'statusDateAfter' => $this->statusDateAfter,
			'statusDateBefore' => $this->statusDateBefore,
			'userTag' => $this->userTag,
			'userTagMatchMode' => $this->userTagMatchMode,
			'runInputTag' => $this->runInputTag,
			'runInputTagMatchMode' => $this->runInputTagMatchMode,
			'runOutputTag' => $this->runOutputTag,
			'runOutputTagMatchMode' => $this->runOutputTagMatchMode,
			'connectorTag' => $this->connectorTag,
			'connectorTagMatchMode' => $this->connectorTagMatchMode,
			'technicalTag' => $this->technicalTag,
			'technicalTagMatchMode' => $this->technicalTagMatchMode,
			'notInRun' => $this->notInRun,
			'notLinkedToSample' => $this->notLinkedToSample,
			'instrumentRunId' => $this->instrumentRunId,
			'pageOffset' => $this->pageOffset,
			'pageToken' => $this->pageToken,
			'pageSize' => $this->pageSize,
			'sort' => $this->sort,
		]);
	}
}
