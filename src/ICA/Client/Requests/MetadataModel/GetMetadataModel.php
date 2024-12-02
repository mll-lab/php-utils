<?php

namespace MLL\Utils\ICA\Client\Requests\MetadataModel;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getMetadataModel
 */
class GetMetadataModel extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/metadataModels/{$this->metadataModelId}";
	}


	/**
	 * @param string $metadataModelId
	 */
	public function __construct(
		protected string $metadataModelId,
	) {
	}
}
