<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectSample;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * linkSampleToProject
 */
class LinkSampleToProject extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


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
