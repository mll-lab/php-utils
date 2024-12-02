<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\ProjectCustomNotificationSubscriptions\CreateCustomNotificationSubscription;
use MLL\Utils\ICA\Client\Requests\ProjectCustomNotificationSubscriptions\DeleteCustomNotificationSubscription;
use MLL\Utils\ICA\Client\Requests\ProjectCustomNotificationSubscriptions\GetCustomNotificationSubscription;
use MLL\Utils\ICA\Client\Requests\ProjectCustomNotificationSubscriptions\GetCustomNotificationSubscriptions;
use MLL\Utils\ICA\Client\Requests\ProjectCustomNotificationSubscriptions\UpdateCustomNotificationSubscription;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class ProjectCustomNotificationSubscriptions extends Resource
{
	/**
	 * @param string $projectId The ID of the project
	 */
	public function getCustomNotificationSubscriptions(string $projectId): Response
	{
		return $this->connector->send(new GetCustomNotificationSubscriptions($projectId));
	}


	/**
	 * @param string $projectId
	 */
	public function createCustomNotificationSubscription(string $projectId): Response
	{
		return $this->connector->send(new CreateCustomNotificationSubscription($projectId));
	}


	/**
	 * @param string $projectId The ID of the project
	 * @param string $subscriptionId The ID of the notification subscription
	 */
	public function getCustomNotificationSubscription(string $projectId, string $subscriptionId): Response
	{
		return $this->connector->send(new GetCustomNotificationSubscription($projectId, $subscriptionId));
	}


	/**
	 * @param string $projectId The ID of the project
	 * @param string $subscriptionId The ID of the custom notification subscription to update
	 */
	public function updateCustomNotificationSubscription(string $projectId, string $subscriptionId): Response
	{
		return $this->connector->send(new UpdateCustomNotificationSubscription($projectId, $subscriptionId));
	}


	/**
	 * @param string $projectId
	 * @param string $subscriptionId The ID of the custom notification subscription to delete
	 */
	public function deleteCustomNotificationSubscription(string $projectId, string $subscriptionId): Response
	{
		return $this->connector->send(new DeleteCustomNotificationSubscription($projectId, $subscriptionId));
	}
}
