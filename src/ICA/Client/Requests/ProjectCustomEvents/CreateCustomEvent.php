<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectCustomEvents;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createCustomEvent
 *
 * Warning: this endpoint allows to create custom events with a code larger than 20 characters (max
 * 50), but the endpoint for creating a custom notification subscription (POST
 * /api/projects/{projectId}/customNotificationSubscriptions) only accepts event codes up to 20
 * characters.
 */
class CreateCustomEvent extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/customEvents";
	}


	/**
	 * @param string $projectId
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
