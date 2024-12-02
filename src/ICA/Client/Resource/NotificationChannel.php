<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\NotificationChannel\CreateNotificationChannel;
use MLL\Utils\ICA\Client\Requests\NotificationChannel\DeleteNotificationChannel;
use MLL\Utils\ICA\Client\Requests\NotificationChannel\GetNotificationChannel;
use MLL\Utils\ICA\Client\Requests\NotificationChannel\GetNotificationChannels;
use MLL\Utils\ICA\Client\Requests\NotificationChannel\UpdateNotificationChannel;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class NotificationChannel extends Resource
{
	public function getNotificationChannels(): Response
	{
		return $this->connector->send(new GetNotificationChannels());
	}


	public function createNotificationChannel(): Response
	{
		return $this->connector->send(new CreateNotificationChannel());
	}


	/**
	 * @param string $channelId The ID of the notification channel to retrieve
	 */
	public function getNotificationChannel(string $channelId): Response
	{
		return $this->connector->send(new GetNotificationChannel($channelId));
	}


	/**
	 * @param string $channelId The ID of the notification channel to update
	 */
	public function updateNotificationChannel(string $channelId): Response
	{
		return $this->connector->send(new UpdateNotificationChannel($channelId));
	}


	/**
	 * @param string $channelId The ID of the notification channel to delete
	 */
	public function deleteNotificationChannel(string $channelId): Response
	{
		return $this->connector->send(new DeleteNotificationChannel($channelId));
	}
}
