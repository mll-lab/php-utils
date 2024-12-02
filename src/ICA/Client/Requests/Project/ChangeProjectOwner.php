<?php

namespace MLL\Utils\ICA\Client\Requests\Project;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * changeProjectOwner
 */
class ChangeProjectOwner extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectIdChangeOwner}";
	}


	/**
	 * @param string $projectId
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
