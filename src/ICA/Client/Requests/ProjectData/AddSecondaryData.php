<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectData;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * addSecondaryData
 */
class AddSecondaryData extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/data/{$this->dataId}/secondaryData/{$this->secondaryDataId}";
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 * @param string $secondaryDataId
	 */
	public function __construct(
		protected string $projectId,
		protected string $dataId,
		protected string $secondaryDataId,
	) {
	}
}
