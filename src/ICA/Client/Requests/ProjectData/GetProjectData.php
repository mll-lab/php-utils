<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectData;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getProjectData
 */
class GetProjectData extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/data/{$this->dataId}";
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
