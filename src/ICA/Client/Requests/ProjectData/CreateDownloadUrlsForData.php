<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectData;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createDownloadUrlsForData
 *
 * Can be used to download files directly from the region where it is located, no connector is needed.
 * Not applicable for Folders.
 */
class CreateDownloadUrlsForData extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/data:createDownloadUrls";
	}


	/**
	 * @param string $projectId
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
