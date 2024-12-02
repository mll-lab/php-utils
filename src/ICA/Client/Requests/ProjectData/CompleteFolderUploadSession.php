<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectData;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * completeFolderUploadSession
 *
 * Complete a trackable folder upload session. By completing the folder upload session, and specifying
 * how many files you have uploaded, ICA can ensure that all uploaded files are accounted for.
 */
class CompleteFolderUploadSession extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/data/{$this->dataId}/folderUploadSessions/{$this->folderUploadSessionIdComplete}";
	}


	/**
	 * @param string $projectId
	 * @param string $dataId
	 * @param string $folderUploadSessionId
	 */
	public function __construct(
		protected string $projectId,
		protected string $dataId,
		protected string $folderUploadSessionId,
	) {
	}
}
