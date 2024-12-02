<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectSample;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * deepDeleteSample
 *
 * Endpoint deleting a sample together with all of its data.This is a non-RESTful endpoint, as the path
 * of this endpoint is not representing a REST resource.
 */
class DeepDeleteSample extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/samples/{$this->sampleIdDeleteDeep}";
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
