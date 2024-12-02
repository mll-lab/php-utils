<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataTransfer;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getDataTransfer
 */
class GetDataTransfer extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataTransfers/{$this->dataTransferId}";
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
