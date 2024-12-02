<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectCustomNotificationSubscriptions;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteCustomNotificationSubscription
 */
class DeleteCustomNotificationSubscription extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/customNotificationSubscriptions/{$this->subscriptionId}";
	}


	/**
	 * @param string $projectId
	 * @param string $subscriptionId The ID of the custom notification subscription to delete
	 */
	public function __construct(
		protected string $projectId,
		protected string $subscriptionId,
	) {
	}
}
