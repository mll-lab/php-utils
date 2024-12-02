<?php

namespace MLL\Utils\ICA\Client\Requests\NotificationChannel;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getNotificationChannels
 */
class GetNotificationChannels extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/notificationChannels";
	}


	public function __construct()
	{
	}
}
