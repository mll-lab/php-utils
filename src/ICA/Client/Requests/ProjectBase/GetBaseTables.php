<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectBase;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBaseTables
 */
class GetBaseTables extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/base/tables";
	}


	/**
	 * @param string $projectId
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
