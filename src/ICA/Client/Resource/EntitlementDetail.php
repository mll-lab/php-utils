<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\EntitlementDetail\FindAllMatchingActivationCodesForCwl;
use MLL\Utils\ICA\Client\Requests\EntitlementDetail\FindAllMatchingActivationCodesForNextflow;
use MLL\Utils\ICA\Client\Requests\EntitlementDetail\FindBestMatchingActivationCodeForCwl;
use MLL\Utils\ICA\Client\Requests\EntitlementDetail\FindBestMatchingActivationCodesForNextflow;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class EntitlementDetail extends Resource
{
	public function findBestMatchingActivationCodeForCwl(): Response
	{
		return $this->connector->send(new FindBestMatchingActivationCodeForCwl());
	}


	public function findBestMatchingActivationCodesForNextflow(): Response
	{
		return $this->connector->send(new FindBestMatchingActivationCodesForNextflow());
	}


	public function findAllMatchingActivationCodesForCwl(): Response
	{
		return $this->connector->send(new FindAllMatchingActivationCodesForCwl());
	}


	public function findAllMatchingActivationCodesForNextflow(): Response
	{
		return $this->connector->send(new FindAllMatchingActivationCodesForNextflow());
	}
}
