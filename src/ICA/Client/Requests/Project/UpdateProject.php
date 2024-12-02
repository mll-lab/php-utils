<?php

namespace MLL\Utils\ICA\Client\Requests\Project;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * updateProject
 *
 * Fields which can be updated:
 * - shortDescription
 * - projectInformation
 * - billingMode
 * -
 * dataSharingEnabled
 * - tags
 * - storageBundle
 * - metaDataModel
 * - analysisPriority
 */
class UpdateProject extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}";
	}


	/**
	 * @param string $projectId
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
