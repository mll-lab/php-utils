<?php

namespace MLL\Utils\ICA\Client\Requests\Data;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createDownloadUrlForDataWithoutProjectContext
 *
 * Can be used to download a file directly from the region where it is located, no connector is needed.
 * Not applicable for Folder.
 */
class CreateDownloadUrlForDataWithoutProjectContext extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/data/{$this->dataUrnCreateDownloadUrl}";
	}


	/**
	 * @param string $dataUrn The format is urn:ilmn:ica:region:\<ID of the region\>:data:\<ID of the data\>#\<optional data path\>. The path can be omitted, in that case the hashtag (#) must also be omitted.
	 */
	public function __construct(
		protected string $dataUrn,
	) {
	}
}
