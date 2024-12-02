<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectData;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getSecondaryData
 */
class GetSecondaryData extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/data/{$this->dataId}/secondaryData";
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function __construct(
		protected string $projectId,
		protected string $dataId,
	) {
	}
}
