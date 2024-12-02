<?php

namespace MLL\Utils\ICA\Client\Requests\NotificationChannel;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getNotificationChannel
 */
class GetNotificationChannel extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/notificationChannels/{$this->channelId}";
	}


	/**
	 * @param string $channelId The ID of the notification channel to retrieve
	 */
	public function __construct(
		protected string $channelId,
	) {
	}
}
