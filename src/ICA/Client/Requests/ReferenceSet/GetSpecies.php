<?php

namespace MLL\Utils\ICA\Client\Requests\ReferenceSet;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getSpecies
 */
class GetSpecies extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/referenceSets/{$this->referenceSetId}/species";
	}


	/**
	 * @param string $referenceSetId
	 */
	public function __construct(
		protected string $referenceSetId,
	) {
	}
}
