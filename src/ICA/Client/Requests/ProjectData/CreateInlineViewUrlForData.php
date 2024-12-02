<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectData;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createInlineViewUrlForData
 *
 * Can be used to view a file directly from the region where it is located, no connector is needed.
 */
class CreateInlineViewUrlForData extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/data/{$this->dataIdCreateInlineViewUrl}";
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
