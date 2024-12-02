<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectSample;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * completeProjectSample
 *
 * Completes the sample after data has been linked to it. The sample status will be set to 'Available'
 * and a sample completed event will be triggered as well.
 */
class CompleteProjectSample extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/samples/{$this->sampleIdComplete}";
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
