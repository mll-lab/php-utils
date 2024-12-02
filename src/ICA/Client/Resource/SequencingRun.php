<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\SequencingRun\GetSequencingRun;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class SequencingRun extends Resource
{
	/**
	 * @param string $sequencingRunId The ID of the sequencing run to retrieve
	 */
	public function getSequencingRun(string $sequencingRunId): Response
	{
		return $this->connector->send(new GetSequencingRun($sequencingRunId));
	}
}
