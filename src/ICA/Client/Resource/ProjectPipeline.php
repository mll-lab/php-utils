<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectPipeline\CreateCwlPipeline;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\CreateNextflowJsonPipeline;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\CreateNextflowPipeline;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\CreateProjectPipelineFile;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\DeleteProjectPipelineFile;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\DownloadProjectPipelineFileContent;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\GetProjectPipeline;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\GetProjectPipelineConfigurationParameters;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\GetProjectPipelineFiles;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\GetProjectPipelineHtmlDocumentation;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\GetProjectPipelineInputParameters;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\GetProjectPipelineReferenceSets;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\GetProjectPipelines;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\LinkPipelineToProject;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\ReleaseProjectPipeline;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\UnlinkPipelineFromProject;
use MLL\Utils\ICA\Client\Requests\ProjectPipeline\UpdateProjectPipelineFile;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectPipeline extends Resource
{
	/**
	 * @param string $projectId The ID of the project to retrieve pipelines for
	 */
	public function getProjectPipelines(string $projectId): Response
	{
		return $this->connector->send(new GetProjectPipelines($projectId));
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to retrieve
	 */
	public function getProjectPipeline(string $projectId, string $pipelineId): Response
	{
		return $this->connector->send(new GetProjectPipeline($projectId, $pipelineId));
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the pipeline
	 */
	public function linkPipelineToProject(string $projectId, string $pipelineId): Response
	{
		return $this->connector->send(new LinkPipelineToProject($projectId, $pipelineId));
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the pipeline
	 */
	public function unlinkPipelineFromProject(string $projectId, string $pipelineId): Response
	{
		return $this->connector->send(new UnlinkPipelineFromProject($projectId, $pipelineId));
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to retrieve input parameters for
	 */
	public function getProjectPipelineInputParameters(string $projectId, string $pipelineId): Response
	{
		return $this->connector->send(new GetProjectPipelineInputParameters($projectId, $pipelineId));
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to retrieve input parameters for
	 */
	public function getProjectPipelineConfigurationParameters(string $projectId, string $pipelineId): Response
	{
		return $this->connector->send(new GetProjectPipelineConfigurationParameters($projectId, $pipelineId));
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the pipeline to retrieve reference sets for
	 */
	public function getProjectPipelineReferenceSets(string $projectId, string $pipelineId): Response
	{
		return $this->connector->send(new GetProjectPipelineReferenceSets($projectId, $pipelineId));
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the pipeline
	 */
	public function releaseProjectPipeline(string $projectId, string $pipelineId): Response
	{
		return $this->connector->send(new ReleaseProjectPipeline($projectId, $pipelineId));
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to retrieve HTML documentation from
	 */
	public function getProjectPipelineHtmlDocumentation(string $projectId, string $pipelineId): Response
	{
		return $this->connector->send(new GetProjectPipelineHtmlDocumentation($projectId, $pipelineId));
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to retrieve files for
	 */
	public function getProjectPipelineFiles(string $projectId, string $pipelineId): Response
	{
		return $this->connector->send(new GetProjectPipelineFiles($projectId, $pipelineId));
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to create a file for
	 */
	public function createProjectPipelineFile(string $projectId, string $pipelineId): Response
	{
		return $this->connector->send(new CreateProjectPipelineFile($projectId, $pipelineId));
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to retrieve files for
	 * @param string $fileId The ID of the pipeline file
	 */
	public function downloadProjectPipelineFileContent(string $projectId, string $pipelineId, string $fileId): Response
	{
		return $this->connector->send(new DownloadProjectPipelineFileContent($projectId, $pipelineId, $fileId));
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to update a file for
	 * @param string $fileId The ID of the pipeline file
	 */
	public function updateProjectPipelineFile(string $projectId, string $pipelineId, string $fileId): Response
	{
		return $this->connector->send(new UpdateProjectPipelineFile($projectId, $pipelineId, $fileId));
	}


	/**
	 * @param string $projectId
	 * @param string $pipelineId The ID of the project pipeline to delete a file for
	 * @param string $fileId The ID of the pipeline file
	 */
	public function deleteProjectPipelineFile(string $projectId, string $pipelineId, string $fileId): Response
	{
		return $this->connector->send(new DeleteProjectPipelineFile($projectId, $pipelineId, $fileId));
	}


	/**
	 * @param string $projectId
	 */
	public function createNextflowJsonPipeline(string $projectId): Response
	{
		return $this->connector->send(new CreateNextflowJsonPipeline($projectId));
	}


	/**
	 * @param string $projectId
	 */
	public function createNextflowPipeline(string $projectId): Response
	{
		return $this->connector->send(new CreateNextflowPipeline($projectId));
	}


	/**
	 * @param string $projectId
	 */
	public function createCwlPipeline(string $projectId): Response
	{
		return $this->connector->send(new CreateCwlPipeline($projectId));
	}
}
