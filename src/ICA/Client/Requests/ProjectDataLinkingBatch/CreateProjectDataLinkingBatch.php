<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectDataLinkingBatch;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createProjectDataLinkingBatch
 *
 * # Changelog
 * For this endpoint multiple versions exist. Note that the values for request headers
 * 'Content-Type' and 'Accept' must contain a matching version.
 *
 * ## [V3]
 * Initial version deprecated.
 * It's recommended to limit the amount of links per batch to 25.000.
 * Recommended to use V4 for
 * performance efficiency.
 * ## [V4]
 * More efficient, handles folder contents via the folder item, instead
 * of creating separate items for all contents.
 */
class CreateProjectDataLinkingBatch extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/dataLinkingBatch";
	}


	/**
	 * @param string $projectId
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
