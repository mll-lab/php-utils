<?php

namespace MLL\Utils\ICA\Client\Resource;

use MLL\Utils\ICA\Client\Requests\Data\CreateDownloadUrlForDataWithoutProjectContext;
use MLL\Utils\ICA\Client\Requests\Data\CreateInlineViewUrlForDataWithoutProjectContext;
use MLL\Utils\ICA\Client\Requests\Data\GetData;
use MLL\Utils\ICA\Client\Resource;
use Saloon\Contracts\Response;

class Data extends Resource
{
	/**
	 * @param string $dataUrn The format is urn:ilmn:ica:region:\<ID of the region\>:data:\<ID of the data\>#\<optional data path\>. The path can be omitted, in that case the hashtag (#) must also be omitted.
	 */
	public function getData(string $dataUrn): Response
	{
		return $this->connector->send(new GetData($dataUrn));
	}


	/**
	 * @param string $dataUrn The format is urn:ilmn:ica:region:\<ID of the region\>:data:\<ID of the data\>#\<optional data path\>. The path can be omitted, in that case the hashtag (#) must also be omitted.
	 */
	public function createInlineViewUrlForDataWithoutProjectContext(string $dataUrn): Response
	{
		return $this->connector->send(new CreateInlineViewUrlForDataWithoutProjectContext($dataUrn));
	}


	/**
	 * @param string $dataUrn The format is urn:ilmn:ica:region:\<ID of the region\>:data:\<ID of the data\>#\<optional data path\>. The path can be omitted, in that case the hashtag (#) must also be omitted.
	 */
	public function createDownloadUrlForDataWithoutProjectContext(string $dataUrn): Response
	{
		return $this->connector->send(new CreateDownloadUrlForDataWithoutProjectContext($dataUrn));
	}
}
