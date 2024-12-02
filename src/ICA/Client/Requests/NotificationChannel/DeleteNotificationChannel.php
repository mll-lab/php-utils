<?php

namespace MLL\Utils\ICA\Client\Requests\NotificationChannel;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteNotificationChannel
 */
class DeleteNotificationChannel extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/notificationChannels/{$this->channelId}";
	}


	/**
	 * @param string $channelId The ID of the notification channel to delete
	 */
	public function __construct(
		protected string $channelId,
	) {
	}
}
