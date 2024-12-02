<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectSample;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getSampleMetadataFieldCount
 *
 * Returns a list of values for the field with identifier fieldId belonging to the sample with
 * identifier sampleId. If the field is a group field that can occur more than once or belongs to a
 * group field that can occur more than once the return value will have one entry in the list for each
 * occurrence. If not the return value will be a single value list
 */
class GetSampleMetadataFieldCount extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/samples/{$this->sampleId}/metadata/{$this->fieldId}/fieldCount";
	}


	/**
	 * @param string $projectId
	 * @param string $sampleId The ID of the sample
	 * @param string $fieldId The ID of the field
	 */
	public function __construct(
		protected string $projectId,
		protected string $sampleId,
		protected string $fieldId,
	) {
	}
}
