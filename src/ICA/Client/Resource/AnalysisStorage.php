<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\AnalysisStorage\GetAnalysisStorageOptions;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class AnalysisStorage extends Resource
{
	public function getAnalysisStorageOptions(): Response
	{
		return $this->connector->send(new GetAnalysisStorageOptions());
	}
}
