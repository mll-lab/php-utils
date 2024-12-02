<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectNotificationSubscriptions\CreateNotificationSubscription;
use MLL\Utils\ICA\Client\Requests\ProjectNotificationSubscriptions\DeleteNotificationSubscription;
use MLL\Utils\ICA\Client\Requests\ProjectNotificationSubscriptions\GetNotificationSubscription;
use MLL\Utils\ICA\Client\Requests\ProjectNotificationSubscriptions\GetNotificationSubscriptions;
use MLL\Utils\ICA\Client\Requests\ProjectNotificationSubscriptions\UpdateNotificationSubscription;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectNotificationSubscriptions extends Resource
{
	/**
	 * @param string $projectId The ID of the project
	 */
	public function getNotificationSubscriptions(string $projectId): Response
	{
		return $this->connector->send(new GetNotificationSubscriptions($projectId));
	}


	/**
	 * @param string $projectId The ID of the project
	 */
	public function createNotificationSubscription(string $projectId): Response
	{
		return $this->connector->send(new CreateNotificationSubscription($projectId));
	}


	/**
	 * @param string $projectId The ID of the project
	 * @param string $subscriptionId The ID of the notification subscription
	 */
	public function getNotificationSubscription(string $projectId, string $subscriptionId): Response
	{
		return $this->connector->send(new GetNotificationSubscription($projectId, $subscriptionId));
	}


	/**
	 * @param string $projectId The ID of the project
	 * @param string $subscriptionId The ID of the notification subscription to update
	 */
	public function updateNotificationSubscription(string $projectId, string $subscriptionId): Response
	{
		return $this->connector->send(new UpdateNotificationSubscription($projectId, $subscriptionId));
	}


	/**
	 * @param string $projectId The ID of the project
	 * @param string $subscriptionId The ID of the notification subscription to delete
	 */
	public function deleteNotificationSubscription(string $projectId, string $subscriptionId): Response
	{
		return $this->connector->send(new DeleteNotificationSubscription($projectId, $subscriptionId));
	}
}
