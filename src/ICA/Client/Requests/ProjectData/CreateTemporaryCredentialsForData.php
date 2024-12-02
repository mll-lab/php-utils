<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectData;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createTemporaryCredentialsForData
 *
 * Can be used to upload or download a file directly from the region where it is located, no connector
 * is needed. The returned credentials expire after 36 hours.
 */
class CreateTemporaryCredentialsForData extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/data/{$this->dataIdCreateTemporaryCredentials}";
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 */
	public function __construct(
		protected string $projectId,
		protected string $dataId,
	) {
	}
}
