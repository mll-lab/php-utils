<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectSample;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectSample
 */
class GetProjectSample extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/samples/{$this->sampleId}";
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 */
	public function __construct(
		protected string $projectId,
		protected string $sampleId,
	) {
	}
}
