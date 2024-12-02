<?php

namespace MLL\Utils\ICA\Client\Requests\NotificationChannel;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createNotificationChannel
 */
class CreateNotificationChannel extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/notificationChannels";
	}


	public function __construct()
	{
	}
}
