<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectNotificationSubscriptions;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getNotificationSubscriptions
 */
class GetNotificationSubscriptions extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/notificationSubscriptions";
	}


	/**
	 * @param string $projectId The ID of the project
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
