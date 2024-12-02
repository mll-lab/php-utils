<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectData;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getFolderUploadSession
 *
 * Retrieve folder upload session details, including the current status of your upload session.
 */
class GetFolderUploadSession extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/data/{$this->dataId}/folderUploadSessions/{$this->folderUploadSessionId}";
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
