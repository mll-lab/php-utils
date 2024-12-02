<?php

namespace MLL\Utils\ICA\Client\Requests\ProjectBase;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * loadData
 *
 * Load data in the specified table
 */
class LoadData extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/projects/{$this->projectId}/base/tables/{$this->tableIdLoadData}";
	}


	/**
	 * @param string $projectId
	 * @param string $tableId
	 */
	public function __construct(
		protected string $projectId,
		protected string $tableId,
	) {
	}
}
