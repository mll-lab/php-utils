<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\Project\ChangeProjectOwner;
use MLL\Utils\ICA\Client\Requests\Project\CreateProject;
use MLL\Utils\ICA\Client\Requests\Project\GetProject;
use MLL\Utils\ICA\Client\Requests\Project\GetProjectBundle;
use MLL\Utils\ICA\Client\Requests\Project\GetProjectBundles;
use MLL\Utils\ICA\Client\Requests\Project\GetProjects;
use MLL\Utils\ICA\Client\Requests\Project\HideProject;
use MLL\Utils\ICA\Client\Requests\Project\LinkProjectBundle;
use MLL\Utils\ICA\Client\Requests\Project\UnlinkProjectBundle;
use MLL\Utils\ICA\Client\Requests\Project\UpdateProject;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class Project extends Resource
{
	/**
	 * @param string $search Search
	 * @param array $userTags User tags to filter on
	 * @param array $technicalTags Technical tags to filter on
	 * @param bool $includeHiddenProjects Include hidden projects.
	 * @param string $region The ID of the region to filter on.
	 * @param array $workgroups Workgroup IDs to filter on
	 * @param string $pageOffset [only use with offset-based paging]<br>The amount of rows to skip in the result. Ideally this is a multiple of the size parameter. Offset-based pagination has a result limit of 200K rows and does not guarantee unique results across pages
	 * @param string $pageToken [only use with cursor-based paging]<br>The cursor to get subsequent results. The value to use is returned in the result when using cursor-based pagination. Cursor-based pagination guarantees complete and unique results across all pages.
	 * @param string $pageSize [can be used with both offset- and cursor-based paging]<br>The amount of rows to return. Use in combination with the offset (when using offset-based pagination) or cursor (when using cursor-based pagination) parameter to get subsequent results
	 * @param string $sort [only use with offset-based paging]<br>Which field to order the results by. The default order is ascending, suffix with ' desc' to sort descending (suffix ' asc' also works for ascending). Multiple values should be separated with commas. An example: "?sort=sortAttribute1, sortAttribute2 desc"
	 *
	 * The attributes for which sorting is supported:
	 * - name
	 * - shortDescription
	 * - information
	 */
	public function getProjects(
		?string $search,
		?array $userTags,
		?array $technicalTags,
		?bool $includeHiddenProjects,
		?string $region,
		?array $workgroups,
		?string $pageOffset,
		?string $pageToken,
		?string $pageSize,
		?string $sort,
	): Response
	{
		return $this->connector->send(new GetProjects($search, $userTags, $technicalTags, $includeHiddenProjects, $region, $workgroups, $pageOffset, $pageToken, $pageSize, $sort));
	}


	public function createProject(): Response
	{
		return $this->connector->send(new CreateProject());
	}


	/**
	 * @param string $projectId
	 */
	public function getProject(string $projectId): Response
	{
		return $this->connector->send(new GetProject($projectId));
	}


	/**
	 * @param string $projectId
	 */
	public function updateProject(string $projectId): Response
	{
		return $this->connector->send(new UpdateProject($projectId));
	}


	/**
	 * @param string $projectId
	 */
	public function getProjectBundles(string $projectId): Response
	{
		return $this->connector->send(new GetProjectBundles($projectId));
	}


	/**
	 * @param string $projectId
	 * @param string $bundleId
	 */
	public function getProjectBundle(string $projectId, string $bundleId): Response
	{
		return $this->connector->send(new GetProjectBundle($projectId, $bundleId));
	}


	/**
	 * @param string $projectId
	 * @param string $bundleId
	 */
	public function linkProjectBundle(string $projectId, string $bundleId): Response
	{
		return $this->connector->send(new LinkProjectBundle($projectId, $bundleId));
	}


	/**
	 * @param string $projectId
	 * @param string $bundleId
	 */
	public function unlinkProjectBundle(string $projectId, string $bundleId): Response
	{
		return $this->connector->send(new UnlinkProjectBundle($projectId, $bundleId));
	}


	/**
	 * @param string $projectId
	 */
	public function hideProject(string $projectId): Response
	{
		return $this->connector->send(new HideProject($projectId));
	}


	/**
	 * @param string $projectId
	 */
	public function changeProjectOwner(string $projectId): Response
	{
		return $this->connector->send(new ChangeProjectOwner($projectId));
	}
}
