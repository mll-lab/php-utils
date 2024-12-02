<?php

namespace MLL\Utils\ICA\Client\Requests\SequencingRun;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getSequencingRun
 */
class GetSequencingRun extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/sequencingRuns/{$this->sequencingRunId}";
	}


	/**
	 * @param string $sequencingRunId The ID of the sequencing run to retrieve
	 */
	public function __construct(
		protected string $sequencingRunId,
	) {
	}
}
