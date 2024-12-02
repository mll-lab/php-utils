<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectNotificationSubscriptions;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * createNotificationSubscription
 */
class CreateNotificationSubscription extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/notificationSubscriptions";
	}


	/**
	 * @param string $projectId The ID of the project
	 */
	public function __construct(
		protected string $projectId,
	) {
	}
}
