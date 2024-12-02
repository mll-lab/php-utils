<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataTransfer;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * abortDataTransfer
 *
 * Endpoint for aborting a data transfer.This is a non-RESTful endpoint, as the path of this endpoint
 * is not representing a REST resource.
 */
class AbortDataTransfer extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataTransfers/{$this->dataTransferIdAbort}";
	}


	/**
	 * @param string $projectId
	 * @param string $dataTransferId
	 */
	public function __construct(
		protected string $projectId,
		protected string $dataTransferId,
	) {
	}
}
