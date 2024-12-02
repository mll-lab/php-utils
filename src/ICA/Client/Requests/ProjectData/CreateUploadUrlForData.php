<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectData;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createUploadUrlForData
 *
 * Can be used to upload a file directly from the region where it is located, no connector is needed.
 * The project identifier must match the project which owns the data. You can create both new files and
 * overwrite files in status 'partial'.
 */
class CreateUploadUrlForData extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/data/{$this->dataIdCreateUploadUrl}";
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 * @param null|string $fileType
	 * @param null|string $hash
	 */
	public function __construct(
		protected string $projectId,
		protected string $dataId,
		protected ?string $fileType = null,
		protected ?string $hash = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['fileType' => $this->fileType, 'hash' => $this->hash]);
	}
}
