<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectNotificationSubscriptions;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteNotificationSubscription
 */
class DeleteNotificationSubscription extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/notificationSubscriptions/{$this->subscriptionId}";
	}


	/**
	 * @param string $projectId The ID of the project
	 * @param string $subscriptionId The ID of the notification subscription to delete
	 */
	public function __construct(
		protected string $projectId,
		protected string $subscriptionId,
	) {
	}
}
