<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectCustomNotificationSubscriptions;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getCustomNotificationSubscriptions
 */
class GetCustomNotificationSubscriptions extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/customNotificationSubscriptions";
	}


	/**
	 * @param string $projectId The ID of the project
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
