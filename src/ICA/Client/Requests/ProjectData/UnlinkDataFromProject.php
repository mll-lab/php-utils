<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectData;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * unlinkDataFromProject
 *
 * Note that for folders, this only unlinks the folder itself, not the folder contents!  Use 'Project
 * Data Unlinking Batch' for recursive unlinking.
 */
class UnlinkDataFromProject extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/data/{$this->dataIdUnlink}";
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
