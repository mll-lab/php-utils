<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataCopyBatch;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createProjectDataCopyBatch
 */
class CreateProjectDataCopyBatch extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataCopyBatch";
	}


	/**
	 * @param string $projectId The ID of the project to which the data will be copied
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
