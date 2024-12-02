<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectData;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * updateProjectData
 *
 * Fields which can be updated for files:
 *  - data.willBeArchivedAt
 *  - data.willBeDeletedAt
 *  -
 * data.format
 *  - data.tags
 *
 * Fields which can be updated for folders:
 *  - data.tags
 */
class UpdateProjectData extends Request
{
	protected Method $method = Method::PUT;


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
