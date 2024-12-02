<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataUpdateBatch;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createProjectDataUpdateBatch
 *
 * Avoid specifying more than 5000 total dataIds per call if possible (specifying more than 100000 is
 * not allowed).
 */
class CreateProjectDataUpdateBatch extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataUpdateBatch";
	}


	/**
	 * @param string $projectId
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
