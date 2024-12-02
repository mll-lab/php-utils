<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\User\ApproveUser;
use MLL\Utils\ICA\Client\Requests\User\AssignTenantAdminRightsToUser;
use MLL\Utils\ICA\Client\Requests\User\GetUser;
use MLL\Utils\ICA\Client\Requests\User\GetUsers;
use MLL\Utils\ICA\Client\Requests\User\RevokeTenantAdminRightsToUser;
use MLL\Utils\ICA\Client\Requests\User\UpdateUser;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class User extends Resource
{
	/**
	 * @param string $emailAddress The email address to filter on
	 */
	public function getUsers(?string $emailAddress): Response
	{
		return $this->connector->send(new GetUsers($emailAddress));
	}


	/**
	 * @param string $userId
	 */
	public function getUser(string $userId): Response
	{
		return $this->connector->send(new GetUser($userId));
	}


	/**
	 * @param string $userId
	 */
	public function updateUser(string $userId): Response
	{
		return $this->connector->send(new UpdateUser($userId));
	}


	/**
	 * @param string $userId
	 */
	public function approveUser(string $userId): Response
	{
		return $this->connector->send(new ApproveUser($userId));
	}


	/**
	 * @param string $userId
	 */
	public function assignTenantAdminRightsToUser(string $userId): Response
	{
		return $this->connector->send(new AssignTenantAdminRightsToUser($userId));
	}


	/**
	 * @param string $userId
	 */
	public function revokeTenantAdminRightsToUser(string $userId): Response
	{
		return $this->connector->send(new RevokeTenantAdminRightsToUser($userId));
	}
}
