<?php

namespace MLL\Utils\ICA\Client\Requests\Job;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getJob
 */
class GetJob extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/jobs/{$this->jobId}";
	}


	/**
	 * @param string $jobId The ID of the job.
	 */
	public function __construct(
		protected string $jobId,
	) {
	}
}
