<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectData;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * removeSecondaryData
 */
class RemoveSecondaryData extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/data/{$this->dataId}/secondaryData/{$this->secondaryDataId}";
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 * @param string $secondaryDataId
	 */
	public function __construct(
		protected string $projectId,
		protected string $dataId,
		protected string $secondaryDataId,
	) {
	}
}
