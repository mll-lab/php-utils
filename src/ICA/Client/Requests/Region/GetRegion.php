<?php

namespace MLL\Utils\ICA\Client\Requests\Region;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getRegion
 */
class GetRegion extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/regions/{$this->regionId}";
	}


	/**
	 * @param string $regionId
	 */
	public function __construct(
		protected string $regionId,
	) {
	}
}
