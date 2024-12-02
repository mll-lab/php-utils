<?php

namespace MLL\Utils\ICA\Client\Requests\NotificationChannel;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * updateNotificationChannel
 *
 * This will affect all subscriptions which use this address!Fields which can be updated:
 *  - enabled
 *  -
 * address
 *  - awsRegion
 */
class UpdateNotificationChannel extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/notificationChannels/{$this->channelId}";
	}


	/**
	 * @param string $channelId The ID of the notification channel to update
	 */
	public function __construct(
		protected string $channelId,
	) {
	}
}
