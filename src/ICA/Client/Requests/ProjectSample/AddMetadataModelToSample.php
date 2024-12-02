<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectSample;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * addMetadataModelToSample
 */
class AddMetadataModelToSample extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/samples/{$this->sampleId}/metadata/{$this->metadataModelId}";
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 * @param string $metadataModelId The ID of the metadata model
	 */
	public function __construct(
		protected string $projectId,
		protected string $sampleId,
		protected string $metadataModelId,
	) {
	}
}
