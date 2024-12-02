<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\Pipeline\DownloadPipelineFileContent;
use MLL\Utils\ICA\Client\Requests\Pipeline\GetPipeline;
use MLL\Utils\ICA\Client\Requests\Pipeline\GetPipelineConfigurationParameters;
use MLL\Utils\ICA\Client\Requests\Pipeline\GetPipelineFiles;
use MLL\Utils\ICA\Client\Requests\Pipeline\GetPipelineHtmlDocumentation;
use MLL\Utils\ICA\Client\Requests\Pipeline\GetPipelineInputParameters;
use MLL\Utils\ICA\Client\Requests\Pipeline\GetPipelineReferenceSets;
use MLL\Utils\ICA\Client\Requests\Pipeline\GetPipelines;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class Pipeline extends Resource
{
	public function getPipelines(): Response
	{
		return $this->connector->send(new GetPipelines());
	}


	/**
	 * @param string $pipelineId The ID of the pipeline to retrieve
	 */
	public function getPipeline(string $pipelineId): Response
	{
		return $this->connector->send(new GetPipeline($pipelineId));
	}


	/**
	 * @param string $pipelineId The ID of the pipeline to retrieve input parameters for
	 */
	public function getPipelineInputParameters(string $pipelineId): Response
	{
		return $this->connector->send(new GetPipelineInputParameters($pipelineId));
	}


	/**
	 * @param string $pipelineId
	 */
	public function getPipelineConfigurationParameters(string $pipelineId): Response
	{
		return $this->connector->send(new GetPipelineConfigurationParameters($pipelineId));
	}


	/**
	 * @param string $pipelineId The ID of the pipeline to retrieve reference sets for
	 */
	public function getPipelineReferenceSets(string $pipelineId): Response
	{
		return $this->connector->send(new GetPipelineReferenceSets($pipelineId));
	}


	/**
	 * @param string $pipelineId The ID of the project pipeline to retrieve HTML documentation from
	 */
	public function getPipelineHtmlDocumentation(string $pipelineId): Response
	{
		return $this->connector->send(new GetPipelineHtmlDocumentation($pipelineId));
	}


	/**
	 * @param string $pipelineId The ID of the project pipeline to retrieve files for
	 */
	public function getPipelineFiles(string $pipelineId): Response
	{
		return $this->connector->send(new GetPipelineFiles($pipelineId));
	}


	/**
	 * @param string $pipelineId The ID of the project pipeline to retrieve files for
	 * @param string $fileId The ID of the pipeline file
	 */
	public function downloadPipelineFileContent(string $pipelineId, string $fileId): Response
	{
		return $this->connector->send(new DownloadPipelineFileContent($pipelineId, $fileId));
	}
}
