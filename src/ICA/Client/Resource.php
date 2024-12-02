<?php

namespace MLL\Utils\ICA\Client;

use Saloon\Http\Connector;

class Resource
{
	public function __construct(
		protected Connector $connector,
	) {
	}
}
