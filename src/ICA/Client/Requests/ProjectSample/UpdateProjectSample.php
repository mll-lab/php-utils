<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectSample;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * updateProjectSample
 *
 * Fields which can be updated:
 * - sample.name
 * - sample.description
 * - sample.status
 * - sample.tags
 */
class UpdateProjectSample extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/samples/{$this->sampleId}";
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId
	 */
	public function __construct(
		protected string $projectId,
		protected string $sampleId,
	) {
	}
}
