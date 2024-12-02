<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectCustomNotificationSubscriptions;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * updateCustomNotificationSubscription
 *
 * Fields which can be updated:
 *  - enabled
 *  - eventCode
 *  - filterExpression
 *  - notificationChannel
 */
class UpdateCustomNotificationSubscription extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/customNotificationSubscriptions/{$this->subscriptionId}";
	}


	/**
	 * @param string $projectId The ID of the project
	 * @param string $subscriptionId The ID of the custom notification subscription to update
	 */
	public function __construct(
		protected string $projectId,
		protected string $subscriptionId,
	) {
	}
}
