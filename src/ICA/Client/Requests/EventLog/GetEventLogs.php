<?php

namespace MLL\Utils\ICA\Client\Requests\EventLog;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getEventLogs
 */
class GetEventLogs extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/eventLog";
	}


	/**
	 * @param null|string $code Code
	 * @param null|string $codeFilterType Code filter type
	 * @param null|string $category Category
	 * @param null|string $dateFrom Date from. Format: yyyy-MM-dd'T'HH:mm:ss.SSS'Z' eg: 2017-01-10T10:47:56.039Z
	 * @param null|string $dateUntil Date until. Format: yyyy-MM-dd'T'HH:mm:ss.SSS'Z' eg: 2017-01-10T10:47:56.039Z
	 * @param null|int $rows Amount of rows to fetch (chronologically oldest first). Maximum 250. Defaults to 250
	 */
	public function __construct(
		protected ?string $code = null,
		protected ?string $codeFilterType = null,
		protected ?string $category = null,
		protected ?string $dateFrom = null,
		protected ?string $dateUntil = null,
		protected ?int $rows = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter([
			'code' => $this->code,
			'codeFilterType' => $this->codeFilterType,
			'category' => $this->category,
			'dateFrom' => $this->dateFrom,
			'dateUntil' => $this->dateUntil,
			'rows' => $this->rows,
		]);
	}
}
