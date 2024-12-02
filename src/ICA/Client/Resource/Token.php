<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\Token\CreateJwtToken;
use MLL\Utils\ICA\Client\Requests\Token\RefreshJwtToken;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class Token extends Resource
{
	/**
	 * @param string $tenant The name of your tenant in case you have access to multiple tenants.
	 */
	public function createJwtToken(?string $tenant): Response
	{
		return $this->connector->send(new CreateJwtToken($tenant));
	}


	public function refreshJwtToken(): Response
	{
		return $this->connector->send(new RefreshJwtToken());
	}
}
