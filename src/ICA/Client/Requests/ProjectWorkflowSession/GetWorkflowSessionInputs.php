<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectWorkflowSession;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getWorkflowSessionInputs
 */
class GetWorkflowSessionInputs extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/workflowSessions/{$this->workflowSessionId}/inputs";
	}


	/**
	 * @param string $projectId
	 * @param string $workflowSessionId The ID of the workflow session to retrieve the inputs for
	 */
	public function __construct(
		protected string $projectId,
		protected string $workflowSessionId,
	) {
	}
}
