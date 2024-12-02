<?php

namespace MLL\Utils\ICA\Client\Requests\Data;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getData
 */
class GetData extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/data/{$this->dataUrn}";
	}


	/**
	 * @param string $dataUrn The format is urn:ilmn:ica:region:\<ID of the region\>:data:\<ID of the data\>#\<optional data path\>. The path can be omitted, in that case the hashtag (#) must also be omitted.
	 */
	public function __construct(
		protected string $dataUrn,
	) {
	}
}
