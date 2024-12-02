<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectPermission\CreateProjectPermission;
use MLL\Utils\ICA\Client\Requests\ProjectPermission\GetProjectPermission;
use MLL\Utils\ICA\Client\Requests\ProjectPermission\GetProjectPermissions;
use MLL\Utils\ICA\Client\Requests\ProjectPermission\UpdateProjectPermission;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectPermission extends Resource
{
	/**
	 * @param string $projectId
	 */
	public function getProjectPermissions(string $projectId): Response
	{
		return $this->connector->send(new GetProjectPermissions($projectId));
	}


	/**
	 * @param string $projectId
	 */
	public function createProjectPermission(string $projectId): Response
	{
		return $this->connector->send(new CreateProjectPermission($projectId));
	}


	/**
	 * @param string $projectId
	 * @param string $permissionId
	 */
	public function getProjectPermission(string $projectId, string $permissionId): Response
	{
		return $this->connector->send(new GetProjectPermission($projectId, $permissionId));
	}


	/**
	 * @param string $projectId
	 * @param string $permissionId
	 */
	public function updateProjectPermission(string $projectId, string $permissionId): Response
	{
		return $this->connector->send(new UpdateProjectPermission($projectId, $permissionId));
	}
}
