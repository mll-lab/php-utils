<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ReferenceSet\GetReferenceSets;
use MLL\Utils\ICA\Client\Requests\ReferenceSet\GetSpecies;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ReferenceSet extends Resource
{
	public function getReferenceSets(): Response
	{
		return $this->connector->send(new GetReferenceSets());
	}


	/**
	 * @param string $referenceSetId
	 */
	public function getSpecies(string $referenceSetId): Response
	{
		return $this->connector->send(new GetSpecies($referenceSetId));
	}
}
