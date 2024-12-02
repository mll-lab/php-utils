<?php

namespace MLL\Utils\ICA\Client\Requests\Workgroup;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getWorkgroup
 */
class GetWorkgroup extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/workgroups/{$this->workgroupId}";
	}


	/**
	 * @param string $workgroupId The ID of the workgroup to retrieve
	 */
	public function __construct(
		protected string $workgroupId,
	) {
	}
}
