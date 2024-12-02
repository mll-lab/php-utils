<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectCustomNotificationSubscriptions;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getCustomNotificationSubscription
 */
class GetCustomNotificationSubscription extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/customNotificationSubscriptions/{$this->subscriptionId}";
	}


	/**
	 * @param string $projectId The ID of the project
	 * @param string $subscriptionId The ID of the notification subscription
	 */
	public function __construct(
		protected string $projectId,
		protected string $subscriptionId,
	) {
	}
}
